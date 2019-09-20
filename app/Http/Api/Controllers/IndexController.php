<?php

namespace App\Http\Api\Controllers;


use lumen\extra\facade\Cookie;

class IndexController extends BaseController
{
    public function index()
    {
        Cookie::set('name', 'kain');
        return [
        ];
    }
}
