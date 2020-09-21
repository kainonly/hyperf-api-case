<?php
declare(strict_types=1);

namespace App\Middleware\System;

use App\RedisModel\System\AclRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\Support\Middleware\RbacVerify as BaseRbacVerify;

class RbacVerify extends BaseRbacVerify
{
    protected string $prefix = 'system';
    protected array $ignore = [
        'valided*'
    ];

    public function __construct(RoleRedis $role, AclRedis $acl)
    {
        parent::__construct($role, $acl);
    }
}