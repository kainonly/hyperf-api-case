<?php
declare(strict_types=1);

namespace App\Middleware\System;

use Hyperf\Support\Middleware\RbacVerify as BaseRbacVerify;

class RbacVerify extends BaseRbacVerify
{
    protected string $prefix = 'system';
    protected array $ignore = [
        'valided*'
    ];
}