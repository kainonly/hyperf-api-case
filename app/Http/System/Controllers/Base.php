<?php

namespace App\Http\System\Controllers;

use Illuminate\Http\Request;
use lumen\curd\CurdController;

class Base extends CurdController
{
    public function __construct(Request $request)
    {
        $this->middleware('cors');
        $this->middleware('post');
        $this->request = $request;
        if ($request->method() == 'POST') {
            $this->post = $request->toArray();
        }
    }
}
