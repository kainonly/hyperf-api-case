<?php

namespace App\Http\Api\Controllers;

use Illuminate\Support\Facades\Cookie;

class IndexController extends BaseController
{
    public function index()
    {
        Cookie::queue('name', 'kain', 1);
        return [
            'version' => 1.0,
        ];
    }
}
