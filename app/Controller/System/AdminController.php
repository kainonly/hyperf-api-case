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
use Hyperf\Curd\Lifecycle\AddAfterHooks;
use Hyperf\Curd\Lifecycle\AddBeforeHooks;
use Hyperf\Curd\Lifecycle\DeleteAfterHooks;
use Hyperf\Curd\Lifecycle\DeleteBeforeHooks;
use Hyperf\Curd\Lifecycle\EditAfterHooks;
use Hyperf\Curd\Lifecycle\EditBeforeHooks;
use Hyperf\Curd\Lifecycle\GetCustom;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Context;

class AdminController extends BaseController
    implements GetCustom, AddBeforeHooks, AddAfterHooks, EditBeforeHooks, EditAfterHooks, DeleteBeforeHooks, DeleteAfterHooks
{
    use GetModel, OriginListsModel, ListsModel, AddModel, EditModel, DeleteModel;
    protected string $model = 'admin';
    protected string $add_model = 'admin_basic';
    protected string $edit_model = 'admin_basic';
    protected string $delete_model = 'admin_basic';
    protected array $get_field = ['id', 'username', 'role', 'call', 'email', 'phone', 'avatar', 'status'];
    protected array $origin_lists_field = ['id', 'username', 'role', 'call', 'email', 'phone', 'avatar', 'status'];
    protected array $lists_field = ['id', 'username', 'role', 'call', 'email', 'phone', 'avatar', 'status'];
    protected array $add_validate = [
        'username' => 'required|between:4,20',
        'password' => 'required|between:8,18',
        'role' => 'required'
    ];
    protected array $edit_validate = [
        'role' => 'required'
    ];
    private string $role;
    /**
     * @Inject()
     * @var AdminRedis
     */
    private AdminRedis $adminRedis;

    /**
     * @inheritDoc
     */
    public function getCustomReturn(array $data): array
    {
        $username = Context::get('auth')->user;
        $result = Db::table('admin_basic')
            ->where('username', '=', $username)
            ->where('status', '=', 1)
            ->first();

        if (!empty($result) && $result->id === (int)$this->post['id']) {
            $data['self'] = true;
        }

        return [
            'error' => 0,
            'data' => $data
        ];
    }

    /**
     * @inheritDoc
     */
    public function addBeforeHooks(): bool
    {
        $this->role = $this->post['role'];
        $this->post['password'] = $this->hash->create($this->post['password']);
        unset($this->post['role']);
        return true;
    }

    /**
     * @inheritDoc
     */
    public function addAfterHooks(int $id): bool
    {
        $result = Db::table('admin_role')->insert([
            'admin_id' => $id,
            'role_key' => $this->role
        ]);
        if (!$result) {
            $this->add_after_result = [
                'error' => 1,
                'msg' => 'role assoc wrong'
            ];
            return false;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function editBeforeHooks(): bool
    {
        $username = Context::get('auth')->user;
        $rows = Db::table('admin_basic')
            ->where('username', '=', $username)
            ->where('status', '=', 1)
            ->first();
        if (!empty($rows) && $rows->id === $this->post['id']) {
            $this->edit_before_result = [
                'error' => 1,
                'msg' => 'error:self'
            ];
            return false;
        }
        if (!$this->edit_switch) {
            $this->role = $this->post['role'];
            unset($this->post['role']);
            if (!empty($this->post['password'])) {
                $validator = $this->validation->make($this->post, [
                    'password' => 'between:8,18'
                ]);

                if ($validator->fails()) {
                    $this->edit_before_result = [
                        'error' => 1,
                        'msg' => $validator->errors()
                    ];
                    return false;
                }
            } else {
                unset($this->post['password']);
            }
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function editAfterHooks(): bool
    {
        if (!$this->edit_switch) {
            Db::table('admin_role')
                ->where('admin_id', '=', $this->post['id'])
                ->update([
                    'role_key' => $this->role
                ]);
        }
        $this->clearRedis();
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteBeforeHooks(): bool
    {
        $username = Context::get('auth')->user;
        $rows = Db::table('admin_basic')
            ->where('username', '=', $username)
            ->where('status', '=', 1)
            ->first();
        if (!empty($rows) && in_array($rows->id, $this->post['id'], true)) {
            $this->delete_before_result = [
                'error' => 1,
                'msg' => 'error:self'
            ];
            return false;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteAfterHooks(): bool
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
        $this->post = $this->request->post();
        if (empty($this->post['username'])) {
            return [
                'error' => 1,
                'msg' => 'error:require_username'
            ];
        }

        $exists = Db::table('admin_basic')
            ->where('username', '=', $this->post['username'])
            ->exists();

        return [
            'error' => 0,
            'data' => $exists
        ];
    }

}