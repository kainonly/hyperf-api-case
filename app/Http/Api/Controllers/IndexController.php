<?php

namespace App\Http\Api\Controllers;

use Illuminate\Support\Str;

class IndexController extends BaseController
{
    public function index()
    {
        return [
            'version' => 1.0,
            'key' => Str::random(32)
        ];
    }
}
