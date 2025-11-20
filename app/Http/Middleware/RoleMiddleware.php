<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // If user is not logged in OR does not match role
        if (!$request->user() || $request->user()->role !== $role) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
