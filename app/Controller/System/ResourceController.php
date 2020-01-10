<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\ResourceRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Curd\Lifecycle\AddAfterHooks;
use Hyperf\Curd\Lifecycle\DeleteAfterHooks;
use Hyperf\Curd\Lifecycle\DeleteBeforeHooks;
use Hyperf\Curd\Lifecycle\EditAfterHooks;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Annotation\Controller;

/**
 * Class ResourceController
 * @package App\Controller\System
 * @Controller(prefix="system/resource")
 */
class ResourceController extends BaseController implements AddAfterHooks, EditAfterHooks, DeleteBeforeHooks, DeleteAfterHooks
{
    use OriginListsModel, GetModel, AddModel, DeleteModel, EditModel;
    protected $model = 'resource';

    public function __addAfterHooks(int $id): bool
    {
        $this->clearRedis();
        return true;
    }

    public function __editAfterHooks(): bool
    {
        $this->clearRedis();
        return true;
    }

    public function __deleteBeforeHooks(): bool
    {
        $queryData = Db::table($this->model)
            ->whereIn('id', $this->post['id'])
            ->first();

        $exists = Db::table($this->model)
            ->where('parent', '=', $queryData->key)
            ->exists();

        if ($exists) {
            $this->delete_before_result = [
                'error' => 1,
                'msg' => 'error:has_child'
            ];
        }
        return !$exists;
    }

    public function __deleteAfterHooks(): bool
    {
        $this->clearRedis();
        return true;
    }

    /**
     * Sort Lists
     * @return array
     */
    public function sort(): array
    {
        if (empty($this->post['data'])) {
            return [
                'error' => 1,
                'msg' => 'error'
            ];
        }

        return Db::transaction(function () {
            foreach ($this->post['data'] as $value) {
                Db::table($this->model)->update($value);
            }
            $this->clearRedis();
            return true;
        }) ? [
            'error' => 0,
            'msg' => 'success'
        ] : [
            'error' => 1,
            'msg' => 'error'
        ];
    }

    private function clearRedis(): void
    {
        ResourceRedis::create($this->container)->clear();
        RoleRedis::create($this->container)->clear();
    }

    /**
     * Exists Resources Key
     * @return array
     */
    public function validedKey(): array
    {
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