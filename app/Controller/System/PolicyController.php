<?php
declare (strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\RoleRedis;
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Di\Annotation\Inject;
use stdClass;

class PolicyController extends BaseController
{
    use OriginListsModel, AddModel, DeleteModel;

    protected static string $model = 'policy';
    protected static array $originListsOrders = [];
    protected static bool $autoTimestamp = false;
    protected static array $addValidate = [
        'resource_key' => 'required',
        'acl_key' => 'required',
        'policy' => 'required'
    ];

    /**
     * @Inject()
     * @var RoleRedis
     */
    private RoleRedis $roleRedis;

    public function addAfterHook(stdClass $ctx): bool
    {
        $this->clearRedis();
        return true;
    }

    public function deleteAfterHook(stdClass $ctx): bool
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
    }
}