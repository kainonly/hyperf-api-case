<?php
declare(strict_types=1);

namespace App\Middleware\System;

use Hyperf\Extra\Auth\AuthMiddleware;

class AuthVerify extends AuthMiddleware
{
    protected string $scene = 'system';
}