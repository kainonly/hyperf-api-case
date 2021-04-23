<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\Client\CosClient;
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
     * @var CosClient
     */
    private CosClient $cosClient;

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
        $ip = get_client_ip();
        if (!$locker->check('ip:' . $ip)) {
            $locker->lock('ip:' . $ip);
            return $this->response->json([
                'error' => 2,
                'msg' => '当前尝试登录失败次数上限，请稍后再试'
            ]);
        }
        $user = $body['username'];
        $data = $this->adminRedis->get($user);
        if (empty($data)) {
            $locker->inc('ip:' . $ip);
            return $this->response->json([
                'error' => 1,
                'msg' => '当前用户不存在或已被冻结'
            ]);
        }
        $userKey = 'admin:';
        if (!$locker->check($userKey . $user)) {
            $locker->lock($userKey . $user);
            return $this->response->json([
                'error' => 2,
                'msg' => '当前用户登录失败次数以上限，请稍后再试'
            ]);
        }
        if (!$this->hash->check($body['password'], $data['password'])) {
            $locker->inc($userKey . $user);
            return $this->response->json([
                'error' => 1,
                'msg' => '当前用户认证不成功'
            ]);
        }
        $locker->remove('ip:' . $ip);
        $locker->remove($userKey . $user);

        return $this->create('system', [
            'user' => $data['username'],
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
        return $this->cosClient->generatePostPresigned([
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
        $this->cosClient->delete($body['keys']);
        return [
            'error' => 0,
            'msg' => 'ok'
        ];
    }
}