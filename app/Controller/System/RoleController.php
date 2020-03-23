<?php
declare (strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\AdminRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Curd\Lifecycle\AddAfterHooks;
use Hyperf\Curd\Lifecycle\AddBeforeHooks;
use Hyperf\Curd\Lifecycle\DeleteAfterHooks;
use Hyperf\Curd\Lifecycle\EditAfterHooks;
use Hyperf\Curd\Lifecycle\EditBeforeHooks;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

/**
 * Class RoleController
 * @package App\Controller\System
 */
class RoleController extends BaseController
    implements AddBeforeHooks, AddAfterHooks, EditBeforeHooks, EditAfterHooks, DeleteAfterHooks
{
    use GetModel, OriginListsModel, ListsModel, AddModel, EditModel, DeleteModel;
    protected string $model = 'role';
    protected string $add_model = 'role_basic';
    protected string $edit_model = 'role_basic';
    protected string $delete_model = 'role_basic';
    protected array $add_validate = [
        'name' => 'required',
        'key' => 'required',
        'resource' => 'required|array'
    ];
    protected array $edit_validate = [
        'name' => 'required',
        'key' => 'required',
        'resource' => 'required|array'
    ];
    private array $resource = [];
    /**
     * @Inject()
     * @var RoleRedis
     */
    private RoleRedis $roleRedis;
    /**
     * @Inject()
     * @var AdminRedis
     */
    private AdminRedis $adminRedis;

    /**
     * @inheritDoc
     */
    public function addBeforeHooks(): bool
    {
        $this->resource = $this->post['resource'];
        unset($this->post['resource']);
        return true;
    }

    /**
     * @inheritDoc
     */
    public function addAfterHooks(int $id): bool
    {
        $resourceLists = [];
        foreach ($this->resource as $key => $value) {
            $resourceLists[] = [
                'role_key' => $this->post['key'],
                'resource_key' => $value
            ];
        }
        $result = Db::table('role_resource')
            ->insert($resourceLists);
        if (!$result) {
            return false;
        }
        $this->clearRedis();
        return true;
    }

    /**
     * @inheritDoc
     */
    public function editBeforeHooks(): bool
    {
        if (!$this->edit_model) {
            $this->resource = $this->post['resource'];
            unset($this->post['resource']);
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function editAfterHooks(): bool
    {
        if (!$this->edit_model) {
            $resourceLists = [];
            foreach ($this->resource as $key => $value) {
                $resourceLists[] = [
                    'role_key' => $this->post['key'],
                    'resource_key' => $value
                ];
            }
            Db::table('role_resource')
                ->where('role_key', '=', $this->post['key'])
                ->delete();
            $result = Db::table('role_resource')
                ->insert($resourceLists);
            if (!$result) {
                return false;
            }
        }
        $this->clearRedis();
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
     * Clear Cache
     */
    private function clearRedis(): void
    {
        $this->roleRedis->clear();
        $this->adminRedis->clear();
    }

    /**
     * Exists Role Key
     * @return array
     */
    public function validedKey(): array
    {
        $this->post = $this->request->post();
        if (empty($this->post['key'])) {
            return [
                'error' => 1,
                'msg' => 'error:require_key'
            ];
        }

        $exists = Db::table($this->model)
            ->where('key', '=', $this->post['key'])
            ->exists();

        return [
            'error' => 0,
            'data' => $exists
        ];
    }
}