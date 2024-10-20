<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = Auth::user();
        $user->load('role.permissions');

        if (!$this->roleHasAnyPermission($user->role)) {
            abort(403, 'Unauthorized action. You do not have permission to access this.');
        }

        return $next($request);
    }

    /**
     * Check if the role has any permissions.
     *
     * @param Role $role
     * @return bool
     */
    protected function roleHasAnyPermission(Role $role): bool
    {
        return $role && $role->permissions->isNotEmpty();
    }
}
