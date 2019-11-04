<?php

namespace App\Http\System\Middleware;

use Closure;
use App\Http\System\Redis\AclRedis;
use App\Http\System\Redis\RoleRedis;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Lumen\Extra\Facade\Context;

class SystemRbacVerify
{
    private $except_prefix = [
        'valided'
    ];

    public function handle(Request $request, Closure $next)
    {
        [, $controller, $action] = explode('/', Str::lower($request->path()));
        foreach ($this->except_prefix as $value) {
            if (Str::is($value, $action)) {
                return $next($request);
            }
        }
        $roleKey = Context::get('auth')->role;
        $roleLists = [];
        foreach ($roleKey as $value) {
            array_push(
                $roleLists,
                ...RoleRedis::create()->get($value, 'acl')
            );
        }
        rsort($roleLists);
        $policy = null;
        foreach ($roleLists as $value) {
            [$roleController, $roleAction] = explode(':', Str::lower($value));
            if ($roleController == $controller) {
                $policy = $roleAction;
                break;
            }
        }
        if (is_null($policy)) {
            return response()->json([
                'error' => 1,
                'msg' => 'rbac invalid'
            ], 401);
        }
        $aclLists = array_map(function ($value) {
            return Str::lower($value);
        }, AclRedis::create()->get($controller, $policy));
        if (empty($aclLists)) {
            return response()->json([
                'error' => 1,
                'msg' => 'rbac invalid'
            ], 401);
        }
        return in_array($action, $aclLists) ? $next($request) : response()->json([
            'error' => 1,
            'msg' => 'rbac invalid'
        ], 401);
    }
}
