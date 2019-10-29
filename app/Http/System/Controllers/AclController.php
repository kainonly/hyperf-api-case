<?php

namespace App\Http\System\Controllers;

use App\Http\System\Redis\AclRedis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Lumen\Curd\Common\AddModel;
use Lumen\Curd\Common\DeleteModel;
use Lumen\Curd\Common\EditModel;
use Lumen\Curd\Common\GetModel;
use Lumen\Curd\Common\ListsModel;
use Lumen\Curd\Common\OriginListsModel;
use Lumen\Curd\Lifecycle\AddAfterHooks;
use Lumen\Curd\Lifecycle\DeleteAfterHooks;
use Lumen\Curd\Lifecycle\EditAfterHooks;

class AclController extends BaseController implements AddAfterHooks, EditAfterHooks, DeleteAfterHooks
{
    use GetModel, OriginListsModel, ListsModel, AddModel, EditModel, DeleteModel;
    protected $model = 'acl';
    protected $add_validate = [
        'key' => 'required|string',
        'name' => 'required|json'
    ];
    protected $edit_validate = [
        'key' => 'required|string',
        'name' => 'required|json'
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
     * Modify post processing
     * @return mixed
     */
    public function __editAfterHooks()
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
     * Clear Acl Redis
     * @return bool
     */
    private function clearRedis()
    {
        return AclRedis::create()->clear();
    }

    /**
     * Validate Exists Acl Key
     * @return array
     * @api /system/acl/valided_key
     */
    public function validedKey()
    {
        $validator = Validator::make($this->post, [
            'key' => 'required|string',
        ]);

        if ($validator->fails()) return [
            'error' => 1,
            'msg' => $validator->errors()
        ];

        $exists = DB::table($this->model)
            ->where('key', '=', $this->post['key'])
            ->exists();

        return [
            'error' => 0,
            'data' => $exists
        ];
    }
}
