<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PhoneVerifiedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (empty(\Auth::user()->phone_verified_at)) {
            return redirect()->route('verification.phone.notice');
        }


        return $next($request);
    }
}
