<?php

namespace App\Middleware;

use Hyperf\Support\Middleware\AuthVerify;

class SystemAuthVerify extends AuthVerify
{
    protected $scene = 'system';
}