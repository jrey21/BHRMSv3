<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $requiredPosition)
    {
        // Get the authenticated user
        $user = Auth::user();

        // If no user is logged in OR user position doesn't match, return 403 Forbidden
        if (!$user || $user->position !== $requiredPosition) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
