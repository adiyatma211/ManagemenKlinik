<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next, $role)
    {
        // Check if the user has the required role
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        // If the user doesn't have the required role, abort with 403 Forbidden
        abort(403, 'Unauthorized action.');
    }
}
