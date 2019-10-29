<?php

namespace App\Http\System\Controllers;

use App\Http\System\Redis\RoleRedis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Lumen\Curd\Common\AddModel;
use Lumen\Curd\Common\DeleteModel;
use Lumen\Curd\Common\EditModel;
use Lumen\Curd\Lifecycle\AddAfterHooks;
use Lumen\Curd\Lifecycle\AddBeforeHooks;
use Lumen\Curd\Lifecycle\DeleteAfterHooks;
use Lumen\Curd\Lifecycle\EditAfterHooks;
use Lumen\Curd\Lifecycle\EditBeforeHooks;

class RoleBasicController extends BaseController implements
    AddBeforeHooks, AddAfterHooks, EditBeforeHooks, EditAfterHooks, DeleteAfterHooks
{
    use AddModel, EditModel, DeleteModel;
    protected $model = 'role_basic';
    protected $add_validate = [];
    protected $edit_validate = [];
    private $resource = [];

    /**
     * Add pre-processing
     * @return boolean
     */
    public function __addBeforeHooks()
    {
        $this->resource = $this->post['resource'];
        unset($this->post['resource']);
        return true;
    }

    /**
     * Add post processing
     * @param string|int $id
     * @return mixed
     */
    public function __addAfterHooks($id)
    {
        $data = [];
        foreach ($this->resource as $key => $value) {
            array_push($data, [
                'role_key' => $this->post['key'],
                'resource_key' => $value
            ]);
        }
        $result = DB::table('role_resource')->insert($data);
        return $result && $this->clearRedis();
    }

    /**
     * Modify preprocessing
     * @return boolean
     */
    public function __editBeforeHooks()
    {
        if (!$this->edit_switch) {
            $this->resource = $this->post['resource'];
            unset($this->post['resource']);
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
            $data = [];
            foreach ($this->resource as $key => $value) {
                array_push($data, [
                    'role_key' => $this->post['key'],
                    'resource_key' => $value
                ]);
            }
            $delete = DB::table('role_resource')
                ->where('role_key', '=', $this->post['key'])
                ->delete();
            if (!$delete) {
                return false;
            }
            $result = DB::table('role_resource')->insert($data);
            if (!$result) {
                return false;
            }
        }
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

    /**
     * Validate Exists Role Key
     * @return array
     * @api /system/role/valided_key
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

        $exists = DB::table('role_basic')
            ->where('key', '=', $this->post['key'])
            ->exists();

        return [
            'error' => 0,
            'data' => $exists
        ];
    }
}
