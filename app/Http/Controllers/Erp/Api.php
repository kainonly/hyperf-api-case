<?php

namespace App\Http\Controllers\Erp;

use App\RedisModel\ErpApi;
use Illuminate\Database\QueryException;
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

class Api extends Base implements AddAfterHooks, EditAfterHooks, DeleteAfterHooks
{
    use GetModel, OriginListsModel, ListsModel, AddModel, EditModel, DeleteModel;
    protected $model = 'api';
    protected $add_validate = [
        'type' => 'required|integer',
        'name' => 'required|string',
        'api' => 'required|string',
        'status' => 'required'
    ];
    protected $edit_validate = [
        'type' => 'sometimes|integer',
        'name' => 'sometimes|string',
        'api' => 'sometimes|string',
        'status' => 'required'
    ];

    /**
     * Add post processing
     * @param string|int $id
     * @return mixed
     */
    public function __addAfterHooks($id)
    {
        $result = $this->setRedis();
        if (!$result) $this->add_after_result = [
            'error' => 1,
            'msg' => 'error:redis'
        ];
        return $result;
    }

    /**
     * Modify post processing
     * @return mixed
     */
    public function __editAfterHooks()
    {
        $result = $this->setRedis();
        if (!$result) $this->edit_after_result = [
            'error' => 1,
            'msg' => 'error:redis'
        ];
        return $result;
    }

    /**
     * Delete post processing
     * @return mixed
     */
    public function __deleteAfterHooks()
    {
        $result = $this->setRedis();
        if ($result) $this->delete_before_result = [
            'error' => 1,
            'msg' => 'error:redis'
        ];
        return $result;
    }

    /**
     * 验证Api
     * @return array
     */
    public function validateApi()
    {
        $validator = Validator::make($this->post, [
            'api' => 'required|string',
        ]);

        if ($validator->fails()) return [
            'error' => 1,
            'msg' => $validator->errors()
        ];

        try {
            $exists = DB::table($this->model)
                ->where('api', '=', $this->post['api'])
                ->exists();

            return [
                'error' => 0,
                'data' => $exists
            ];
        } catch (QueryException $e) {
            return [
                'error' => 1,
                'msg' => $e->getMessage()
            ];
        }
    }

    /**
     * 刷新缓存
     * @return bool
     */
    private function setRedis()
    {
        return ErpApi::refresh();
    }

}
