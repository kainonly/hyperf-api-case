<?php
declare(strict_types=1);

namespace App\Middleware\System;

use Hyperf\Support\Middleware\AuthVerify as BaseAuthVerify;

class AuthVerify extends BaseAuthVerify
{
    protected string $scene = 'system';
}