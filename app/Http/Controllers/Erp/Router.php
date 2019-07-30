<?php

namespace App\Http\Controllers\Erp;

use App\RedisModel\ErpRouter;
use Illuminate\Database\QueryException;
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

class Router extends Base implements AddAfterHooks, EditAfterHooks, DeleteBeforeHooks, DeleteAfterHooks
{
    use GetModel, OriginListsModel, AddModel, EditModel, DeleteModel;
    protected $model = 'router';
    protected $origin_lists_order_columns = 'sort';
    protected $origin_lists_order_direct = 'asc';
    protected $add_validate = [
        'name' => 'required|string',
        'parent' => 'required|integer',
        'routerlink' => 'sometimes|string',
        'nav' => 'required',
        'status' => 'required'
    ];
    protected $edit_validate = [
        'name' => 'required|string',
        'parent' => 'required|integer',
        'routerlink' => 'sometimes|string',
        'nav' => 'required',
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
     * Delete pre-processing
     * @return boolean
     */
    public function __deleteBeforeHooks()
    {
        try {
            $exists = DB::table($this->model)
                ->where('parent', '=', $this->post['id'])
                ->exists();

            if ($exists) $this->delete_before_result = [
                'error' => 1,
                'msg' => 'error:has_child'
            ];
            return !$exists;
        } catch (QueryException $e) {
            $this->delete_before_result = [
                'error' => 1,
                'msg' => $e->getMessage()
            ];
            return false;
        }
    }

    /**
     * Delete post processing
     * @return mixed
     */
    public function __deleteAfterHooks()
    {
        $result = $this->setRedis();
        if (!$result) $this->delete_after_result = [
            'error' => 1,
            'msg' => 'error:redis'
        ];
        return $result;
    }

    /**
     * 路由排序
     * @return array
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

        $result = DB::transaction(function () {
            foreach ($this->post['data'] as $value) {
                DB::table($this->model)
                    ->where('id', '=', $value['id'])
                    ->update([
                        'sort' => $value['sort']
                    ]);
            }

            return $this->setRedis();
        });

        return $result ? [
            'error' => 0,
            'msg' => 'ok'
        ] : [
            'error' => 1,
            'msg' => 'error:update_fails'
        ];
    }

    /**
     * 路由地址验证
     * @return array
     */
    public function validateRouterlink()
    {
        $validator = Validator::make($this->post, [
            'routerlink' => 'required|string',
        ]);

        if ($validator->fails()) return [
            'error' => 1,
            'msg' => $validator->errors()
        ];

        try {
            $exists = DB::table($this->model)
                ->where('routerlink', '=', $this->post['routerlink'])
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
     * 缓存刷新
     * @return bool
     */
    private function setRedis()
    {
        return ErpRouter::refresh();
    }
}
