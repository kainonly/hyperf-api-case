<?php
declare (strict_types=1);

namespace App\Controller\System;


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

class RoleController extends BaseController
    implements AddBeforeHooks, AddAfterHooks, EditBeforeHooks, EditAfterHooks, DeleteAfterHooks
{
    use GetModel, OriginListsModel, ListsModel, AddModel, EditModel, DeleteModel;
    protected string $model = 'role';
    protected string $add_model = 'role_basic';
    protected string $edit_model = 'role_basic';
    protected string $delete_model = 'role_basic';
    private array $resource = [];

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
            array_push($resourceLists, [
                'role_key' => $this->post['key'],
                'resource_key' => $value
            ]);
        }
        $result = Db::table('role_resource')
            ->insert($resourceLists);
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteAfterHooks(): bool
    {
        // TODO: Implement deleteAfterHooks() method.
    }

    /**
     * @inheritDoc
     */
    public function editAfterHooks(): bool
    {
        // TODO: Implement editAfterHooks() method.
    }

    /**
     * @inheritDoc
     */
    public function editBeforeHooks(): bool
    {
        // TODO: Implement editBeforeHooks() method.
    }
}