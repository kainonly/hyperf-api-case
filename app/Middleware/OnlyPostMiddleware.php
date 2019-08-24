<?php

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OnlyPostMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $request->method() == 'POST' ?
            $next($request) :
            Response::create([]);
    }
}
