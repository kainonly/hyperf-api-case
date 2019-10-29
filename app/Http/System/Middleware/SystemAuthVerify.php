<?php

namespace App\Http\System\Middleware;

use Lumen\Support\Middleware\AuthVerify;

class SystemAuthVerify extends AuthVerify
{
    protected $scene = 'system';
}
