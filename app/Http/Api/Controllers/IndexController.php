<?php

namespace App\Http\Api\Controllers;

use Illuminate\Support\Facades\Request;

class IndexController extends BaseController
{
    public function index()
    {
        return [
            'status' => 'ok',
        ];
    }
}
