<?php

namespace App\Http\System\Controllers;

use App\Http\System\Redis\ResourceRedis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use lumen\curd\common\AddModel;
use lumen\curd\common\DeleteModel;
use lumen\curd\common\EditModel;
use lumen\curd\common\GetModel;
use lumen\curd\common\OriginListsModel;
use lumen\curd\lifecycle\AddAfterHooks;
use lumen\curd\lifecycle\DeleteAfterHooks;
use lumen\curd\lifecycle\DeleteBeforeHooks;
use lumen\curd\lifecycle\EditAfterHooks;

class ResourceController extends BaseController implements
    AddAfterHooks, EditAfterHooks, DeleteBeforeHooks, DeleteAfterHooks
{
    use GetModel, OriginListsModel, AddModel, EditModel, DeleteModel;
    protected $model = 'resource';
    protected $origin_lists_order = ['sort'];
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
     * Delete pre-processing
     * @return boolean
     */
    public function __deleteBeforeHooks()
    {
        $data = DB::table($this->model)
            ->whereIn('id', $this->post['id'])
            ->first();

        $result = DB::table($this->model)
            ->where('parent', '=', $data->key)
            ->count();

        if (!empty($result)) {
            $this->delete_before_result = [
                'error' => 1,
                'msg' => 'error:has_child'
            ];
        }

        return empty($result);
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
     * Sort Resource
     * @return array
     * @api /system/resource/sort
     */
    public function sort()
    {
        $validator = Validator::make($this->post, [
            'data' => 'required|array',
            'data.*.id' => 'required|integer',
            'data.*.sort' => 'required|integer'
        ]);

        if ($validator->fails()) return [
            'error' => 1,
            'msg' => $validator->errors()
        ];

        return DB::transaction(function () {
            foreach ($this->post['data'] as $value) {
                DB::table($this->model)->update($value);
            }
            return $this->clearRedis();
        }) ? [
            'error' => 0,
            'msg' => 'success'
        ] : [
            'error' => 1,
            'msg' => 'error'
        ];
    }

    /**
     * Clear Resource Redis
     * @return bool
     */
    private function clearRedis()
    {
        return (new ResourceRedis)->clear();
    }

    /**
     * Validate Resource Key
     * @return array
     * @api /system/resource/valided_key
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
