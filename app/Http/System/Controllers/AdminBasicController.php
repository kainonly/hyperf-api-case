<?php

namespace App\Http\System\Controllers;

use App\Http\System\Redis\AdminRedis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Lumen\Curd\Common\AddModel;
use Lumen\Curd\Common\DeleteModel;
use Lumen\Curd\Common\EditModel;
use Lumen\Curd\Lifecycle\AddAfterHooks;
use Lumen\Curd\Lifecycle\AddBeforeHooks;
use Lumen\Curd\Lifecycle\DeleteAfterHooks;
use Lumen\Curd\Lifecycle\DeleteBeforeHooks;
use Lumen\Curd\Lifecycle\EditAfterHooks;
use Lumen\Curd\Lifecycle\EditBeforeHooks;
use Lumen\Extra\Facade\Context;

class AdminBasicController extends BaseController implements
    AddBeforeHooks, AddAfterHooks, EditBeforeHooks, EditAfterHooks, DeleteBeforeHooks, DeleteAfterHooks
{
    use AddModel, EditModel, DeleteModel;
    protected $model = 'admin_basic';
    private $role;

    /**
     * Add pre-processing
     * @return boolean
     */
    public function __addBeforeHooks()
    {
        $this->role = $this->post['role'];
        unset($this->post['role']);
        $this->post['password'] = Hash::make($this->post['password']);
        return true;
    }

    /**
     * Add post processing
     * @param string|int $id
     * @return mixed
     */
    public function __addAfterHooks($id)
    {
        $result = DB::table('admin_role')->insert([
            'admin_id' => $id,
            'role_key' => $this->role
        ]);
        return $result && $this->clearRedis();
    }

    /**
     * Modify preprocessing
     * @return boolean
     */
    public function __editBeforeHooks()
    {
        $username = Context::get('auth')->username;
        $rows = DB::table('admin_basic')
            ->where('username', '=', $username)
            ->where('status', '=', 1)
            ->first();

        if ($rows->id == $this->post['id']) {
            $this->edit_before_result = [
                'error' => 1,
                'msg' => 'error:self'
            ];
            return false;
        }

        if (!$this->edit_switch) {
            if (!empty($this->post['role'])) {
                $this->role = $this->post['role'];
                unset($this->post['role']);
            }

            if (!empty($this->post['password'])) {
                $validator = Validator::make($this->post, [
                    'password' => 'required|string|between:8,18'
                ]);

                if ($validator->fails()) {
                    $this->edit_before_result = [
                        'error' => 1,
                        'msg' => $validator->errors()
                    ];
                    return false;
                }

                $this->post['password'] = Hash::make($this->post['password']);
            } else {
                unset($this->post['password']);
            }
        }
        return true;
    }

    /**
     * Modify post processing
     * @return mixed
     */
    public function __editAfterHooks()
    {
        if (!$this->edit_switch) {
            DB::table('admin_role')
                ->where('admin_id', '=', $this->post['id'])
                ->update([
                    'role_key' => $this->role
                ]);
        }

        return $this->clearRedis();
    }

    /**
     * Delete pre-processing
     * @return boolean
     */
    public function __deleteBeforeHooks()
    {
        $username = Context::get('auth')->username;
        $result = DB::table($this->model)
            ->where('username', '=', $username)
            ->where('status', '=', 1)
            ->first();
        if (in_array($result->id, $this->post['id'])) {
            $this->delete_before_result = [
                'error' => 1,
                'msg' => 'error:self'
            ];
            return false;
        }
        return true;
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
     * Clear Admin Redis
     * @return bool
     */
    private function clearRedis()
    {
        return (new AdminRedis)->clear();
    }

    /**
     * Validate Exists Username
     * @return array
     * @api /system/admin/valided_username
     */
    public function validedUsername()
    {
        $validator = Validator::make($this->post, [
            'username' => 'required|string|between:4,20',
        ]);

        if ($validator->fails()) return [
            'error' => 1,
            'msg' => $validator->errors()
        ];

        $exists = DB::table('admin_basic')
            ->where('username', '=', $this->post['username'])
            ->exists();

        return [
            'error' => 0,
            'data' => $exists
        ];
    }

}
