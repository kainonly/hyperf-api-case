<?php

namespace App\Middleware;

use Hyperf\Support\Middleware\AuthVerify;

class AppAuthVerify extends AuthVerify
{
    protected $scene = 'app';
}