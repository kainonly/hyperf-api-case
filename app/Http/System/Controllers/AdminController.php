<?php

namespace App\Http\System\Controllers;

use Illuminate\Support\Facades\DB;
use lumen\curd\common\GetModel;
use lumen\curd\common\ListsModel;
use lumen\curd\common\OriginListsModel;
use lumen\curd\lifecycle\GetCustom;
use lumen\extra\facade\Auth;

class AdminController extends BaseController implements GetCustom
{
    use GetModel, OriginListsModel, ListsModel;
    protected $model = 'admin';
    protected $get_field = ['id', 'username', 'role', 'call', 'status', 'email', 'phone', 'avatar'];
    protected $origin_lists_field = ['id', 'username', 'role', 'call', 'status', 'email', 'phone', 'avatar'];
    protected $lists_field = ['id', 'username', 'role', 'call', 'status', 'email', 'phone', 'avatar'];

    /**
     * Customize individual data returns
     * @param mixed $data
     * @return array
     */
    public function __getCustomReturn($data)
    {
        $username = Auth::symbol('system')->user;
        $rows = DB::table('admin_basic')
            ->where('username', '=', $username)
            ->where('status', '=', 1)
            ->first();
        if ($rows->id == $this->post['id']) {
            $data['self'] = true;
        }
        return [
            'error' => 0,
            'data' => $data
        ];
    }
}
