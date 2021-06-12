<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\Service\CommonService;
use App\Service\CosService;
use App\Service\OpenApiService;
use Hyperf\Di\Annotation\Inject;
use Exception;
use App\RedisModel\System\AdminRedis;
use App\RedisModel\System\ResourceRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\DbConnection\Db;
use Hyperf\Extra\Auth\Auth;
use Hyperf\Extra\Rbac\Rbac;
use Hyperf\Extra\Redis\Lock;
use Hyperf\Extra\Redis\RefreshToken;
use Hyperf\Nats\Driver\DriverInterface;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;

class MainController extends BaseController
{
    use Auth, Rbac;

    /**
     * @Inject()
     * @var RefreshToken
     */
    private RefreshToken $refreshToken;
    /**
     * @Inject()
     * @var Lock
     */
    private Lock $lock;
    /**
     * @Inject()
     * @var AdminRedis
     */
    private AdminRedis $adminRedis;
    /**
     * @Inject()
     * @var ResourceRedis
     */
    private ResourceRedis $resourceRedis;
    /**
     * @Inject()
     * @var RoleRedis
     */
    private RoleRedis $roleRedis;
    /**
     * @Inject()
     * @var CosService
     */
    private CosService $cos;
    /**
     * @Inject()
     * @var CommonService
     */
    private CommonService $common;
    /**
     * @Inject()
     * @var DriverInterface
     */
    private DriverInterface $nats;
    /**
     * @Inject()
     * @var OpenApiService
     */
    private OpenApiService $openapi;

    /**
     * 用户登录
     */
    public function login(): ResponseInterface
    {
        $body = $this->curd->should([
            'username' => ['required', 'between:4,20'],
            'password' => ['required', 'between:12,20'],
        ]);
        $locker = $this->lock;
        $address = $this->common->getClinetIp();
        $ipData = $this->openapi->ip($address);
        $ipData['ip'] = $address;
        if (!$locker->check('ip:' . $address)) {
            $locker->lock('ip:' . $address);
            $this->loginRecord($body, $ipData, false, 'IP 登录锁定');
            return $this->response->json([
                'error' => 2,
                'msg' => '当前尝试登录失败次数上限，请稍后再试'
            ]);
        }
        $user = $body['username'];
        $data = $this->adminRedis->get($user);
        if (empty($data)) {
            $locker->inc('ip:' . $address);
            $this->loginRecord($body, $ipData, false, '用户登录失败上限');
            return $this->response->json([
                'error' => 1,
                'msg' => '当前用户不存在或已被冻结'
            ]);
        }
        $userKey = 'admin:';
        if (!$locker->check($userKey . $user)) {
            $locker->lock($userKey . $user);
            $this->loginRecord($body, $ipData, false, '用户登录失败上限');
            return $this->response->json([
                'error' => 2,
                'msg' => '当前用户登录失败次数以上限，请稍后再试'
            ]);
        }
        if (!$this->hash->check($body['password'], $data['password'])) {
            $locker->inc($userKey . $user);
            $this->loginRecord($body, $ipData, false, '用户登录密码不正确');
            return $this->response->json([
                'error' => 1,
                'msg' => '当前用户认证不成功'
            ]);
        }
        $locker->remove('ip:' . $address);
        $locker->remove($userKey . $user);
        $this->loginRecord($body, $ipData, true);
        return $this->create('system', [
            'user' => $data['username'],
        ]);
    }

    /**
     * 登录日志
     * @param bool $logged 登录成功
     * @param string|null $risk 备注
     */
    private function loginRecord(array $body, array $data, bool $logged, ?string $risk = null): void
    {
        $this->nats->publish('logger.activities', [
            'platform' => 'console',
            'username' => $body['username'],
            'ip' => $data['ip'],
            'country' => $data['country'],
            'region' => $data['region'],
            'province' => $data['province'],
            'city_id' => $data['cityId'],
            'city' => $data['city'],
            'isp' => $data['isp'],
            'logged' => $logged,
            'device' => $this->request->getHeader('user-agent')[0],
            'password' => !$logged ? $body['password'] : null,
            'risk' => $risk,
            'time' => time(),
        ]);
    }

    /**
     * 用户登出
     */
    public function logout(): ResponseInterface
    {
        return $this->destory('system');
    }

    /**
     * 用户验证
     */
    public function verify(): ResponseInterface
    {
        return $this->authVerify('system');
    }

    /**
     * 获取资源
     * @return array
     */
    public function resource(): array
    {
        return [
            'error' => 0,
            'data' => $this->fetchResource(
                $this->resourceRedis,
                $this->adminRedis,
                $this->roleRedis
            )
        ];
    }

    /**
     * 个人信息
     * @return array
     */
    public function information(): array
    {
        $user = Context::get('auth')['user'];
        $data = Db::table('admin')
            ->where('username', '=', $user)
            ->first();

        if (empty($data)) {
            return [
                'error' => 1,
                'msg' => '当前用户不存在'
            ];
        }

        return [
            'error' => 0,
            'data' => [
                'username' => $data->username,
                'email' => $data->email,
                'phone' => $data->phone,
                'call' => $data->call,
                'avatar' => $data->avatar
            ]
        ];
    }

    /**
     * 更新个人信息
     * @return array
     */
    public function update(): array
    {
        $body = $this->curd->should([
            'old_password' => [
                'sometimes',
                'between:12,20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&-+])(?=.*[0-9])[\w|@$!%*?&-+]+$/'
            ],
            'new_password' => [
                'required_with:old_password',
                'between:12,20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&-+])(?=.*[0-9])[\w|@$!%*?&-+]+$/'
            ],
        ]);
        $user = Context::get('auth')['user'];
        $data = Db::table('admin')
            ->where('username', '=', $user)
            ->first();

        if (empty($data)) {
            return [
                'error' => 1,
                'msg' => '当前用户不存在'
            ];
        }

        if (!empty($body['old_password'])) {
            if (!$this->hash->check($body['old_password'], $data->password)) {
                return [
                    'error' => 2,
                    'msg' => '用户密码验证失败'
                ];
            }
            $body['password'] = $this->hash->create($body['new_password']);
        }

        unset($body['old_password'], $body['new_password']);
        Db::table('admin')
            ->where('username', '=', $user)
            ->update($body);

        $this->adminRedis->clear();
        return [
            'error' => 0,
            'msg' => 'ok'
        ];
    }

    /**
     * 对象存储签名
     * @return array
     * @throws Exception
     */
    public function presigned(): array
    {
        return $this->cos->generatePostPresigned([
            ['content-length-range', 0, 104857600]
        ]);
    }

    /**
     * 指定删除对象
     * @return array
     * @throws Exception
     */
    public function objectDelete(): array
    {
        $body = $this->curd->should([
            'keys' => 'required|array'
        ]);
        $this->cos->delete($body['keys']);
        return [
            'error' => 0,
            'msg' => 'ok'
        ];
    }
}