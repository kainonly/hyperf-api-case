<?php

namespace App\Http\System\Controllers;

use App\Http\System\Redis\RoleRedis;
use lumen\curd\common\AddModel;
use lumen\curd\common\DeleteModel;
use lumen\curd\common\OriginListsModel;
use lumen\curd\lifecycle\AddAfterHooks;
use lumen\curd\lifecycle\DeleteAfterHooks;

class PolicyController extends BaseController implements AddAfterHooks, DeleteAfterHooks
{
    use OriginListsModel, AddModel, DeleteModel;
    protected $model = 'policy';
    protected $origin_lists_order = [];
    protected $add_auto_timestamp = false;
    protected $add_validate = [
        'resource_key' => 'required|string',
        'acl_key' => 'required|string',
        'policy' => 'required|boolean'
    ];

    /**
     * Add post processing
     * @param string|int $id
     * @return mixed
     */
    public function __addAfterHooks($id)
    {
        return $this->clearRedis();
    }

    /**
     * Delete post processing
     * @return mixed
     */
    public function __deleteAfterHooks()
    {
        return $this->clearRedis();
    }

    /**
     * Clear Role Redis
     * @return bool
     */
    private function clearRedis()
    {
        return (new RoleRedis)->clear();
    }
}
