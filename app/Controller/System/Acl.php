<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\RedisModel\SystemRole;
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
use Hyperf\HttpServer\Annotation\Controller;

/**
 * Class Acl
 * @package App\Controller\System
 * @Controller(prefix="system/acl")
 */
class Acl extends Base implements AddAfterHooks, EditAfterHooks, DeleteAfterHooks
{
    use OriginListsModel, ListsModel, AddModel, GetModel, EditModel, DeleteModel;
    protected $model = 'acl';

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

    public function __deleteAfterHooks(): bool
    {
        $this->clearRedis();
        return true;
    }

    private function clearRedis()
    {
        \App\RedisModel\SystemAcl::create($this->container)->clear();
        SystemRole::create($this->container)->clear();
    }


    /**
     * Exists Acl Key
     * @return array
     */
    public function validedKey()
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
