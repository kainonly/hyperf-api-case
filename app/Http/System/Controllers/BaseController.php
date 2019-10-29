<?php

namespace App\Http\System\Controllers;

use Illuminate\Http\Request;
use lumen\curd\CurdController;

abstract class BaseController extends CurdController
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->post = $request->post();
    }
}
