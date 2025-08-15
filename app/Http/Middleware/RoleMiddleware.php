<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$requiredRoles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = Auth::user()->load('roles.permissions');
        $authCheck = Auth::check();

        // Not logged in
        if (!$authCheck) {
            abort(403, 'Unauthorized');
        }

        // Check if user has any roles
        if ($user->roles->isEmpty()) {
            abort(403, 'Unauthorized');
        }

        // Check if user has Super Admin role
        foreach ($user->roles as $role) {
            if ($role->name === 'super admin') {
                return $next($request);
            }
        }

        // Check if user has permission through any role
        foreach ($user->roles as $role) {
            if ($role->permissions->where('name', $permission)->isNotEmpty()) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized');
    }
}
