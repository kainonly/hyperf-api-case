<?php

namespace App\Http\Api\Controllers;

use Illuminate\Http\Request;

class Index extends Base
{
    public function index(Request $request)
    {
        return [
            'status' => 'ok',
            'method' => $request->method()
        ];
    }
}
