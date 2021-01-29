<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\AdminRedis;
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Context;
use Hyperf\Validation\ValidationException;
use stdClass;

class AdminController extends BaseController
{
    use OriginListsModel, ListsModel, GetModel, AddModel, EditModel, DeleteModel;

    protected static string $model = 'admin_mix';
    protected static string $addModel = 'admin';
    protected static string $editModel = 'admin';
    protected static string $deleteModel = 'admin';
    protected static array $originListsField = ['id', 'username', 'role', 'call', 'email', 'phone', 'avatar', 'status'];
    protected static array $listsField = ['id', 'username', 'role', 'call', 'email', 'phone', 'avatar', 'status'];
    protected static array $getField = ['id', 'username', 'role', 'call', 'email', 'phone', 'avatar', 'status'];
    protected static array $addValidate = [
        'username' => [
            'required',
            'between:4,20'
        ],
        'password' => [
            'required',
            'between:12,20',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&-+])(?=.*[0-9])[\w|@$!%*?&-+]+$/'
        ],
        'role' => ['required']
    ];
    protected static array $editValidate = [
        'role' => ['required_if:switch,false']
    ];

    /**
     * @Inject()
     * @var AdminRedis
     */
    private AdminRedis $adminRedis;

    public function getCustomReturn(array $body, array $result): array
    {
        $username = Context::get('auth')['user'];
        $data = Db::table('admin')
            ->where('username', '=', $username)
            ->where('status', '=', 1)
            ->first();
        if (!empty($data) && $data->id === (int)$body['id']) {
            $result['data']->self = true;
        }
        return $result;
    }

    public function addBeforeHook(stdClass $ctx): bool
    {
        $ctx->role = $ctx->body['role'];
        $ctx->body['password'] = $this->hash->create($ctx->body['password']);
        unset($ctx->body['role']);
        return true;
    }

    public function addAfterHook(stdClass $ctx): bool
    {
        $data = Db::table('admin_role_rel')->insert([
            'admin_id' => $ctx->id,
            'role_key' => $ctx->role
        ]);
        if (!$data) {
            Context::set('error', [
                'error' => 1,
                'msg' => 'role assoc wrong'
            ]);
            return false;
        }
        $this->clearRedis();
        return true;
    }

    public function editBeforeHook(stdClass $ctx): bool
    {
        $username = Context::get('auth')['user'];
        $data = Db::table('admin')
            ->where('username', '=', $username)
            ->where('status', '=', 1)
            ->first();
        if (!empty($data) && $data->id === $ctx->body['id']) {
            Context::set('error', [
                'error' => 2,
                'msg' => 'Detected as currently logged in user'
            ]);
            return false;
        }
        $ctx->role = null;
        if (!$ctx->switch) {
            $ctx->role = $ctx->body['role'];
            unset($ctx->body['role']);
            if (!empty($ctx->body['password'])) {
                $validator = $this->validation->make($ctx->body, [
                    'password' => [
                        'between:12,20',
                        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&-+])(?=.*[0-9])[\w|@$!%*?&-+]+$/'
                    ],
                ]);
                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }
                $ctx->body['password'] = $this->hash->create($ctx->body['password']);
            } else {
                unset($ctx->body['password']);
            }
        }
        return true;
    }

    public function editAfterHook(stdClass $ctx): bool
    {
        if (!$ctx->switch) {
            Db::table('admin_role_rel')
                ->where('admin_id', '=', $ctx->body['id'])
                ->update([
                    'role_key' => $ctx->role
                ]);
        }
        $this->clearRedis();
        return true;
    }

    public function deleteBeforeHook(stdClass $ctx): bool
    {
        $username = Context::get('auth')['user'];
        $data = Db::table('admin')
            ->where('username', '=', $username)
            ->where('status', '=', 1)
            ->first();
        if (!empty($data) && in_array($data->id, $ctx->body['id'], true)) {
            Context::set('error', [
                'error' => 1,
                'msg' => 'is self'
            ]);
            return false;
        }
        return true;
    }

    public function deleteAfterHook(stdClass $ctx): bool
    {
        $this->clearRedis();
        return true;
    }

    /**
     * Clear Redis
     */
    private function clearRedis(): void
    {
        $this->adminRedis->clear();
    }

    /**
     * Exists Acl Key
     * @return array
     */
    public function validedUsername(): array
    {
        $body = $this->request->post();
        if (empty($body['username'])) {
            return [
                'error' => 1,
                'msg' => 'require username'
            ];
        }

        $exists = Db::table('admin')
            ->where('username', '=', $body['username'])
            ->exists();

        return [
            'error' => 0,
            'data' => $exists
        ];
    }

}