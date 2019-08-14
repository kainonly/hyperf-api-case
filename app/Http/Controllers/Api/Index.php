<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Cookie;
use lumen\extra\facade\JwtAuth;

class Index extends Base
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return [
            'status' => 'ok'
        ];
    }

    public function test()
    {
        $data = JwtAuth::setToken('xsrf');
        dump($data);
//        Cookie::queue('nnaa', $data['token']);
    }
}
