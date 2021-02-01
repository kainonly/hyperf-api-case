<?php
declare(strict_types=1);

namespace App\Middleware\System;

use App\RedisModel\System\AclRedis;
use App\RedisModel\System\AdminRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\Extra\Rbac\RbacMiddleware;

class RbacVerify extends RbacMiddleware
{
    protected string $prefix = 'system';
    protected array $ignore = [
        'valided*'
    ];

    public function __construct(RoleRedis $role, AclRedis $acl, AdminRedis $admin)
    {
        parent::__construct($role, $acl, $admin);
    }
}