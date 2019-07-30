<?php

namespace App\Http\Middleware;

use Closure;
use lumen\extra\JwtAuth;

class ErpJwtVerify
{
    private $except = [
        'main/login',
        'main/check'
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

        $result = JwtAuth::tokenVerify('erp');
        if (!$result) {
            JwtAuth::tokenClear('erp');
            return response()->json([
                'error' => 1
            ]);
        } else {
            $request->user = $result->getClaim('user');
            $request->role = $result->getClaim('role');
            $request->symbol = $result->getClaim('symbol');
            return $next($request);
        }
    }
}
