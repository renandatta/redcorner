<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role != 'Administrator' && Auth::user()->role != 'Operator') return redirect()->route('/');
        return $next($request);
    }
}
