<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (empty(auth()->user()) || !auth()->user()->is_admin) {
            abort(403);
        }

        return $next($request);
    }
}
