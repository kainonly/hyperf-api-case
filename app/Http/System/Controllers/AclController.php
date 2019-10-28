<?php

namespace App\Http\System\Controllers;

use App\Http\System\Redis\AclRedis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use lumen\curd\common\AddModel;
use lumen\curd\common\DeleteModel;
use lumen\curd\common\EditModel;
use lumen\curd\common\GetModel;
use lumen\curd\common\ListsModel;
use lumen\curd\common\OriginListsModel;
use lumen\curd\lifecycle\AddAfterHooks;
use lumen\curd\lifecycle\DeleteAfterHooks;
use lumen\curd\lifecycle\EditAfterHooks;

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
        return (new AclRedis)->clear();
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

        $result = DB::table($this->model)
            ->where('key', '=', $this->post['key'])
            ->count();

        return [
            'error' => 0,
            'data' => !empty($result)
        ];
    }
}
