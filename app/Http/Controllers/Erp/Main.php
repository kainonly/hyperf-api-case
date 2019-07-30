<?php

namespace App\Http\Controllers\Erp;

use App\RedisModel\ErpRoleRouter;
use App\RedisModel\ErpRouter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use lumen\bit\common\JwtAuth;

class Main extends Base
{
    /**
     * 登录接口
     * @return array
     */
    public function login()
    {
        $validator = Validator::make($this->post, [
            'username' => 'required|string|between:4,20',
            'password' => 'required|string|between:8,18'
        ]);

        if ($validator->fails()) return [
            'error' => 1,
            'msg' => $validator->errors()
        ];

        $data = DB::table('admin')
            ->where('username', '=', $this->post['username'])
            ->where('status', '=', 1)
            ->first();

        if (!$data) return [
            'error' => 1,
            'msg' => 'error:status'
        ];

        if (!Hash::check($this->post['password'], $data->password)) return [
            'error' => 1,
            'msg' => 'error:incorrect'
        ];

        return JwtAuth::setToken('erp', $data->id, $data->role) ? [
            'error' => 0,
            'msg' => 'ok'
        ] : [
            'error' => 1,
            'msg' => 'failed'
        ];
    }

    /**
     * 验证Token有效性
     * @return mixed
     */
    public function check()
    {
        return JwtAuth::tokenVerify('erp') ? [
            'error' => 0,
            'msg' => 'ok'
        ] : [
            'error' => 1,
            'msg' => 'failed'
        ];
    }

    /**
     * 获取导航数据
     * @return array
     */
    public function menu(Request $request)
    {
        $router = collect(ErpRouter::get());
        $self = collect(ErpRoleRouter::get($request->role));
        $lists = $router->filter(function ($item) use ($self) {
            return $self->contains($item->id);
        });
        return [
            'error' => 0,
            'data' => $lists->values()
        ];
    }

    /**
     * 图片上传
     * @return array
     */
    public function uploads(Request $request)
    {
        $file = $request->file('image');
        if (!$file->isValid()) return [
            'error' => 1,
            'msg' => 'error:uploads_valid'
        ];

        $dir = Carbon::now()->format('Ymd');
        $store = $file->store($dir);

        if (!$store) return [
            'error' => 1,
            'msg' => 'error:uploads_fails'
        ];

        return [
            'error' => 0,
            'data' => [
                'dir' => $dir,
                'hash_name' => $file->hashName()
            ]
        ];
    }
}
