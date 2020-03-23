<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\AclRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Curd\Lifecycle\AddAfterHooks;
use Hyperf\Curd\Lifecycle\DeleteAfterHooks;
use Hyperf\Curd\Lifecycle\EditAfterHooks;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

class AclController extends BaseController implements AddAfterHooks, EditAfterHooks, DeleteAfterHooks
{
    use OriginListsModel, ListsModel, AddModel, GetModel, EditModel, DeleteModel;
    protected string $model = 'acl';
    protected array $add_validate = [
        'key' => 'required',
        'name' => 'required|json'
    ];
    protected array $edit_validate = [
        'key' => 'required',
        'name' => 'required|json'
    ];
    /**
     * @Inject()
     * @var AclRedis
     */
    private AclRedis $aclRedis;
    /**
     * @Inject()
     * @var RoleRedis
     */
    private RoleRedis $roleRedis;

    public function addAfterHooks(int $id): bool
    {
        $this->clearRedis();
        return true;
    }

    public function editAfterHooks(): bool
    {
        $this->clearRedis();
        return true;
    }

    public function deleteAfterHooks(): bool
    {
        $this->clearRedis();
        return true;
    }

    private function clearRedis(): void
    {
        $this->aclRedis->clear();
        $this->roleRedis->clear();
    }

    /**
     * Exists Acl Key
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
