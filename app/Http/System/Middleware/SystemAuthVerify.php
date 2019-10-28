<?php

namespace App\Http\System\Middleware;

use lumen\extra\middleware\AuthVerify;

class SystemAuthVerify extends AuthVerify
{
    protected $scene = 'system';
}
