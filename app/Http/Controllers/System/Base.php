<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use lumen\curd\CurdController;

class Base extends CurdController
{
    public function __construct(Request $request)
    {
        $this->middleware('cors');
        $this->request = $request;
        $this->post = $request->toArray();
    }
}
