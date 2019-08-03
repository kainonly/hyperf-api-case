<?php

namespace App\Http\Controllers\Erp;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use lumen\curd\common\AddModel;
use lumen\curd\common\DeleteModel;
use lumen\curd\common\EditModel;
use lumen\curd\common\GetModel;
use lumen\curd\common\ListsModel;
use lumen\curd\common\OriginListsModel;
use lumen\curd\lifecycle\AddBeforeHooks;
use lumen\curd\lifecycle\DeleteBeforeHooks;
use lumen\curd\lifecycle\EditBeforeHooks;
use lumen\curd\lifecycle\GetCustom;

class Staff extends Base implements GetCustom, AddBeforeHooks, EditBeforeHooks, DeleteBeforeHooks
{
    use GetModel, OriginListsModel, ListsModel, AddModel, EditModel, DeleteModel;
    protected $model = 'staff';
    protected $get_columns = ['id', 'username', 'status'];
    protected $origin_lists_columns = ['id', 'username', 'status'];
    protected $lists_columns = ['id', 'role', 'username', 'status'];
    protected $add_validate = [
        'username' => 'required|string|between:4,20',
        'password' => 'required|string|between:8,18',
        'status' => 'required'
    ];
    protected $edit_validate = [
        'password' => 'sometimes|string|between:8,18',
        'status' => 'required'
    ];

    /**
     * Customize individual data returns
     * @param mixed $data
     * @return array
     */
    public function __getCustomReturn($data)
    {
        if ($this->request->user == (int)$this->post['id']) $data->is_self = true;
        return [
            'error' => 0,
            'data' => $data,
        ];
    }

    /**
     * Add pre-processing
     * @return boolean
     */
    public function __addBeforeHooks()
    {
        $this->post['password'] = Hash::make($this->post['password']);
        return true;
    }

    /**
     * Modify preprocessing
     * @return boolean
     */
    public function __editBeforeHooks()
    {
        if ($this->request->user == $this->post['id']) {
            $this->edit_before_result = [
                'error' => 1,
                'msg' => 'error:is_self'
            ];
            return false;
        }
        if (!$this->edit_switch && isset($this->post['password']) && !empty($this->post['password'])) {
            $this->post['password'] = Hash::make($this->post['password']);
        }
        return true;
    }

    /**
     * Delete pre-processing
     * @return boolean
     */
    public function __deleteBeforeHooks()
    {
        if (in_array($this->request->user, $this->post['id'])) {
            $this->delete_fail_result = [
                'error' => 1,
                'msg' => 'error:is_self'
            ];
            return false;
        }
        return true;
    }

    /**
     * 验证用户名
     * @return array
     */
    public function validateUsername()
    {
        $validator = Validator::make($this->post, [
            'username' => 'required|string|between:4,20',
        ]);

        if ($validator->fails()) return [
            'error' => 1,
            'msg' => $validator->errors()
        ];

        try {
            $exists = DB::table($this->model)
                ->where('username', '=', $this->post['username'])
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

}
