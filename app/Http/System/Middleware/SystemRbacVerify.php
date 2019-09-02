<?php

namespace App\Http\System\Middleware;

use Closure;
use Illuminate\Http\Request;

class SystemRbacVerify
{
    private $except_prefix = [
        'valided'
    ];

    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
