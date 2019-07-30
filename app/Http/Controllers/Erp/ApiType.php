<?php

namespace App\Http\Controllers\Erp;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use lumen\curd\common\AddModel;
use lumen\curd\common\DeleteModel;
use lumen\curd\common\EditModel;
use lumen\curd\common\OriginListsModel;
use lumen\curd\lifecycle\DeleteBeforeHooks;

class ApiType extends Base implements DeleteBeforeHooks
{
    use OriginListsModel, AddModel, EditModel, DeleteModel;
    protected $model = 'api_type';
    protected $add_validate = [
        'name' => 'required|string'
    ];
    protected $edit_validate = [
        'name' => 'sometimes|string'
    ];

    /**
     * Delete pre-processing
     * @return boolean
     */
    public function __deleteBeforeHooks()
    {
        try {
            $exist = DB::table('api')
                ->where('type', '=', $this->post['id'])
                ->exists();

            if ($exist) $this->delete_before_result = [
                'error' => 1,
                'msg' => 'error:api_child'
            ];

            return !$exist;
        } catch (QueryException $e) {
            $this->delete_before_result = [
                'error' => 1,
                'msg' => $e->getMessage()
            ];

            return false;
        }
    }
}
