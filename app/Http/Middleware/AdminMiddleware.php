<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->position !== 'admin') {
            return redirect()->route('userDashboard');
        }

        return $next($request);
    }
}
