<?php

namespace App\Http\Controllers\Erp;

use App\RedisModel\ErpRoleApi;
use App\RedisModel\ErpRoleRouter;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use lumen\curd\common\AddModel;
use lumen\curd\common\DeleteModel;
use lumen\curd\common\EditModel;
use lumen\curd\common\GetModel;
use lumen\curd\common\ListsModel;
use lumen\curd\common\OriginListsModel;
use lumen\curd\lifecycle\AddAfterHooks;
use lumen\curd\lifecycle\AddBeforeHooks;
use lumen\curd\lifecycle\DeleteAfterHooks;
use lumen\curd\lifecycle\DeleteBeforeHooks;
use lumen\curd\lifecycle\EditAfterHooks;
use lumen\curd\lifecycle\EditBeforeHooks;
use lumen\curd\lifecycle\GetCustom;
use lumen\extra\common\Ext;

class Role extends Base implements GetCustom, AddBeforeHooks, AddAfterHooks, EditBeforeHooks, EditAfterHooks, DeleteBeforeHooks, DeleteAfterHooks
{
    use GetModel, OriginListsModel, ListsModel, AddModel, EditModel, DeleteModel;
    protected $model = 'role';
    protected $origin_lists_columns = ['id', 'name', 'status'];
    protected $lists_columns = ['id', 'name', 'status'];
    protected $add_validate = [
        'name' => 'required|string',
        'router' => 'required|array',
        'api' => 'required|array',
        'status' => 'required',
    ];
    protected $edit_validate = [
        'name' => 'sometimes|string',
        'router' => 'sometimes|array',
        'api' => 'sometimes|array',
        'status' => 'required',
    ];

    /**
     * Customize individual data returns
     * @param mixed $data
     * @return array
     */
    public function __getCustomReturn($data)
    {
        $data->router = Ext::unpack($data->router);
        $data->api = Ext::unpack($data->api);
        return [
            'error' => 0,
            'data' => $data
        ];
    }

    /**
     * Add pre-processing
     * @return boolean
     */
    public function __addBeforeHooks()
    {
        $this->post['router'] = Ext::pack($this->post['router']);
        $this->post['api'] = Ext::pack($this->post['api']);
        return true;
    }

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
     * Modify preprocessing
     * @return boolean
     */
    public function __editBeforeHooks()
    {
        if (!$this->edit_switch) {
            $this->post['router'] = Ext::pack($this->post['router']);
            $this->post['api'] = Ext::pack($this->post['api']);
        }
        return true;
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
            $exists = DB::table('admin')
                ->where('role', '=', $this->post['id'])
                ->exists();

            if ($exists) $this->delete_before_result = [
                'error' => 1,
                'msg' => 'error:role_child'
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
     * 刷新缓存
     * @return bool
     */
    private function setRedis()
    {
        return ErpRoleApi::refresh()
            && ErpRoleRouter::refresh();
    }
}
