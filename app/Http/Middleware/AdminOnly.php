<?php

namespace App\Http\Middleware;

use Closure;

class AdminOnly
{
    public function handle($request, Closure $next)
    {
        if (!$request->user()->admin) {
            abort(403);
        } else {
            return $next($request);
        }

    }
}
