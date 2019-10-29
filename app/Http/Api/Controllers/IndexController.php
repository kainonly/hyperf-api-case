<?php

namespace App\Http\Api\Controllers;

use Illuminate\Support\Facades\Redis;

class IndexController extends BaseController
{
    public function index()
    {
        Redis::set('name', 'kain');
        return [
            'version' => 1.0,
        ];
    }
}
