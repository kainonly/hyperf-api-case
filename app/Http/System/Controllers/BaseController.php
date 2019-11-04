<?php

namespace App\Http\System\Controllers;

use Illuminate\Http\Request;
use Lumen\Curd\CurdController;

abstract class BaseController extends CurdController
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->post = $request->post();
        $this->middleware('cors');
        $this->middleware('system.auth');
        $this->middleware('system.rbac');
    }
}
