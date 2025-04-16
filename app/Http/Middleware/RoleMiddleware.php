<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
{
    if (!Auth::check()) {
        abort(403, 'Unauthorized access: User is not authenticated');
    }

    if (Auth::user()->role !== $role) {
        abort(403, 'Unauthorized access: User does not have the required role');
    }

    return $next($request);
}
}


