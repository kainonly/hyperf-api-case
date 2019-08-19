<?php

namespace App\Http\Api\Controllers;

use Illuminate\Support\Facades\DB;

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
        $data = DB::table('role')->get();
        dump($data);
        return [
            'status' => 'ok'
        ];
    }
}
