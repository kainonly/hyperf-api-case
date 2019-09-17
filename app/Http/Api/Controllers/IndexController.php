<?php

namespace App\Http\Api\Controllers;

use Illuminate\Support\Facades\DB;

class IndexController extends BaseController
{
    public function index()
    {
        $data = DB::table('resource')->get();
        return [
            'status' => 'ok',
            'resource' => $data->toArray()
        ];
    }
}
