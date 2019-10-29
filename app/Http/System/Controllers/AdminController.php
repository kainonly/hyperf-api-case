<?php

namespace App\Http\System\Controllers;

use Illuminate\Support\Facades\DB;
use Lumen\Curd\Common\GetModel;
use Lumen\Curd\Common\ListsModel;
use Lumen\Curd\Common\OriginListsModel;
use Lumen\Curd\Lifecycle\GetCustom;
use Lumen\Extra\Facade\Context;

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
        $username = Context::get('auth')['username'];
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
