<?php

namespace App\Http\System\Controllers;

use Illuminate\Support\Facades\DB;
use lumen\curd\common\AddModel;
use lumen\curd\common\DeleteModel;
use lumen\curd\common\EditModel;
use lumen\curd\common\GetModel;
use lumen\curd\common\ListsModel;
use lumen\curd\common\OriginListsModel;
use lumen\curd\lifecycle\AddAfterHooks;
use lumen\curd\lifecycle\DeleteAfterHooks;
use lumen\curd\lifecycle\EditAfterHooks;

class Acl extends Base implements AddAfterHooks, EditAfterHooks, DeleteAfterHooks
{
    use GetModel, OriginListsModel, ListsModel, AddModel, EditModel, DeleteModel;
    protected $model = 'acl';
    protected $add_validate = [
        'key' => 'required',
        'name' => 'required'
    ];
    protected $edit_validate = [
        'key' => 'required',
        'name' => 'required'
    ];

    /**
     * Add post processing
     * @param string|int $id
     * @return mixed
     */
    public function __addAfterHooks($id)
    {
        return $this->setRedis();
    }

    /**
     * Modify post processing
     * @return mixed
     */
    public function __editAfterHooks()
    {
        return $this->setRedis();
    }

    /**
     * Delete post processing
     * @return mixed
     */
    public function __deleteAfterHooks()
    {
        return $this->setRedis();
    }

    private function setRedis()
    {
        return (new \App\Http\System\Redis\Acl)
            ->refresh();
    }

    public function validedKey()
    {
        if (empty($this->post['key'])) {
            return [
                'error' => 1,
                'msg' => 'error:require_key'
            ];
        }

        $result = DB::table($this->model)
            ->where('key', '=', $this->post['key'])
            ->count();

        return [
            'error' => 0,
            'data' => !empty($result)
        ];
    }
}
