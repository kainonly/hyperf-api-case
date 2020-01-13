<?php
declare (strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\RoleRedis;
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Curd\Lifecycle\AddAfterHooks;
use Hyperf\Curd\Lifecycle\DeleteAfterHooks;
use Hyperf\HttpServer\Annotation\Controller;

/**
 * Class PolicyController
 * @package App\Controller\System
 * @Controller(prefix="system/policy")
 */
class PolicyController extends BaseController implements AddAfterHooks, DeleteAfterHooks
{
    use OriginListsModel, AddModel, DeleteModel;
    protected string $model = 'policy';
    protected array $origin_lists_order = [];
    protected bool $add_auto_timestamp = false;

    /**
     * @inheritDoc
     */
    public function addAfterHooks(int $id): bool
    {
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
        RoleRedis::create($this->container)->clear();
    }
}