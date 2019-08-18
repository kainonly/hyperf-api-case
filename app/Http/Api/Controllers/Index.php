<?php

namespace App\Http\Api\Controllers;

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
}
