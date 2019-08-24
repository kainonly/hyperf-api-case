<?php

namespace App\Http\System\Controllers;

use App\Http\System\Redis\Admin;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use lumen\extra\facade\Auth;

class Main extends Base
{
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

        $data = (new Admin)->get($this->post['username']);
        if (empty($data)) return [
            'error' => 1,
            'msg' => 'error:status'
        ];

        if (!Hash::check($this->post['password'], $data->password)) return [
            'error' => 1,
            'msg' => 'error:incorrect'
        ];

        return Auth::set('system', [
            'username' => $data['username'],
            'role' => $data['role']
        ]) ? [
            'error' => 0,
            'msg' => 'ok'
        ] : [
            'error' => 1,
            'msg' => 'failed'
        ];
    }

    public function logout()
    {
        Auth::clear('system');
        return [
            'error' => 0
        ];
    }

    /**
     * 验证有效性
     * @return array
     */
    public function verify()
    {
        return Auth::verify('system') ? [
            'error' => 0,
            'msg' => 'ok'
        ] : [
            'error' => 1,
            'msg' => 'failed'
        ];
    }

    public function resource(Request $request)
    {
        return [
            'error' => 0,
            'data' => []
        ];
    }

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

    public function information()
    {
        $data = DB::table('admin')
            ->where('username', '=', Auth::symbol('system')->username)
            ->where('status', '=', 1)
            ->first();

        return [
            'error' => 0,
            'data' => $data
        ];
    }

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

        $username = Auth::symbol('system')->username;
        $data = DB::table('admin')
            ->where('username', '=', $username)
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
                ->where('username', '=', $username)
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
