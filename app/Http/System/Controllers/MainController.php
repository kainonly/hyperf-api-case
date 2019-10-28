<?php

namespace App\Http\System\Controllers;

use Carbon\Carbon;
use App\Http\System\Redis\ResourceRedis;
use App\Http\System\Redis\RoleRedis;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use lumen\extra\facade\Auth;
use App\Http\System\Redis\AdminRedis;

class MainController extends BaseController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('system.auth', [
            'except' => ['login', 'logout', 'verify']
        ]);
    }

    /**
     * User Login
     * @return array
     * @api /system/main/login
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

        $data = (new AdminRedis)->get($this->post['username']);
        if (!$data) return [
            'error' => 1,
            'msg' => 'error:status'
        ];

        if (!Hash::check($this->post['password'], $data['password'])) {
            return [
                'error' => 1,
                'msg' => 'error:incorrect'
            ];
        }

        return Auth::set('system', [
            'username' => $data['username'],
            'role' => explode(',', $data['role'])
        ]) ? [
            'error' => 0,
            'msg' => 'ok'
        ] : [
            'error' => 1,
            'msg' => 'failed'
        ];
    }

    /**
     * User Logout
     * @return array
     * @api /system/main/logout
     */
    public function logout()
    {
        Auth::clear('system');
        return [
            'error' => 0,
            'msg' => 'ok'
        ];
    }

    /**
     * User Token Verify
     * @return array
     * @api /system/main/verify
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

    /**
     * Get Resource Lists
     * @return array
     * @api /system/main/resource
     */
    public function resource()
    {
        $router = (new ResourceRedis)->get();
        $role = [];
        foreach (Auth::symbol('system')->role as $hasRoleKey) {
            $resource = (new RoleRedis)->get($hasRoleKey, 'resource');
            array_push($role, ...$resource);
        }
        $routerRole = array_unique($role);
        $lists = Arr::where($router, function ($value) use ($routerRole) {
            return in_array($value['key'], $routerRole);
        });
        return [
            'error' => 0,
            'data' => array_values($lists)
        ];
    }

    /**
     * Get Profile Information
     * @return array
     * @api /system/main/information
     */
    public function information()
    {
        $username = Auth::symbol('system')->username;
        $data = DB::table('admin_basic')
            ->where('username', '=', $username)
            ->where('status', '=', 1)
            ->first(['email', 'phone', 'call', 'avatar']);

        return [
            'error' => 0,
            'data' => $data
        ];
    }

    /**
     * Update Profile
     * @return array
     * @api /system/main/update
     */
    public function update()
    {
        $validator = Validator::make($this->post, [
            'old_password' => 'sometimes|between:8,18',
            'new_password' => 'required_with:old_password|between:8,18'
        ]);

        if (!$validator->failed()) return [
            'error' => 1,
            'msg' => $validator->errors()
        ];

        try {
            $username = Auth::symbol('system')->username;
            $data = DB::table('admin_basic')
                ->where('username', '=', $username)
                ->where('status', '=', 1)
                ->first();

            if (!empty($this->post['old_password'])) {
                if (!Hash::check($this->post['old_password'], $data->password)) {
                    return [
                        'error' => 1,
                        'msg' => 'error:password'
                    ];
                }

                $this->post['password'] = Hash::make($this->post['new_password']);
            }

            unset(
                $this->post['old_password'],
                $this->post['new_password']
            );


            DB::table('admin_basic')
                ->where('username', '=', $username)
                ->update($this->post);

            (new AdminRedis)->clear();

            return [
                'error' => 0,
                'msg' => 'ok'
            ];
        } catch (\Exception $e) {
            return [
                'error' => 1,
                'msg' => $e->getMessage()
            ];
        }
    }

    /**
     * Files Upload to Tencent COS
     * @param Request $request
     * @return array
     * @api /system/main/uploads
     */
    public function uploads(Request $request)
    {
        $validator = Validator::make($this->post, [
            'image' => 'required|image',
        ]);

        if (!$validator->failed()) return [
            'error' => 1,
            'msg' => $validator->errors()
        ];

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
