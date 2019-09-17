<?php

namespace App\Http\Api\Controllers;

use Illuminate\Support\Facades\DB;

class IndexController extends BaseController
{
    public function index()
    {
        return [
            'status' => 'ok',
            'resource' => DB::table('resource')->get()
        ];
    }
}
