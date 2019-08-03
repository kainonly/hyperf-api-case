<?php

namespace App\Http\Middleware;

use App\Redis\ErpApi;
use App\Redis\ErpRoleApi;
use Closure;

class ErpRbacVerify
{
    private $except = [
        'main/login',
        'main/check',
        'main/menu',
        'center/clear',
        'center/information',
        'center/update',
        'api/validate_api',
        'router/validate_routerlink',
        'admin/validate_username',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->is($this->except)) {
            return $next($request);
        }

        $apiId = ErpApi::get($request->getRequestUri());
        if (!$apiId) return response()->json([
            'error' => 1,
            'msg' => 'error:not_allowed'
        ]);

        $roleApi = collect(ErpRoleApi::get($request->role));
        if (!$roleApi) return response()->json([
            'error' => 1,
            'msg' => 'error:not_allowed'
        ]);

        return $roleApi->contains($apiId) ? $next($request) : response()->json([
            'error' => 1,
            'msg' => 'error:not_allowed'
        ]);
    }
}
