<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Cookie;

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
        Cookie::queue('name', 'kain', 60);
        return app()->version();
    }
}
