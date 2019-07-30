<?php

namespace App\Http\Controllers\Erp;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use lumen\extra\JwtAuth;

class Center extends Base
{
    /**
     * 清除登录认证
     * @return array
     */
    public function clear()
    {
        JwtAuth::tokenClear('erp');
        return [
            'error' => 0
        ];
    }

    /**
     * 获取个人信息
     * @param Request $request
     * @return array
     */
    public function information(Request $request)
    {
        $data = DB::table('admin')
            ->where('id', '=', $request->user)
            ->where('status', '=', 1)
            ->first(['email', 'phone', 'call']);

        return [
            'error' => 0,
            'data' => $data
        ];
    }

    /**
     * 更新个人信息
     * @param Request $request
     * @return array
     */
    public function update(Request $request)
    {
        $validator = Validator::make($this->post, [
            'old_password' => 'sometimes|between:8,18',
            'new_password' => 'required_with:old_password|between:8,18'
        ]);

        if (!$validator->failed()) return [
            'error' => 1,
            'msg' => $validator->errors()
        ];

        $data = DB::table('admin')
            ->where('id', '=', $request->user)
            ->where('status', '=', 1)
            ->first();

        if (!empty($this->post['old_password'])) {
            if (!Hash::check($this->post['old_password'], $data['password'])) return [
                'error' => 1,
                'msg' => 'error:password'
            ];

            $this->post['password'] = Hash::make($this->post['new_password']);
        }

        unset(
            $this->post['old_password'],
            $this->post['new_password']
        );

        try {
            DB::table('admin')
                ->where('id', '=', $request->user)
                ->update($this->post);

            return [
                'error' => 0,
                'msg' => 'ok'
            ];
        } catch (QueryException $e) {
            return [
                'error' => 1,
                'msg' => $e->getMessage()
            ];
        }
    }
}
