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
     * @param string $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $permission): mixed
    {
        $user = Auth::user();
        $user->load('role.permissions');
        if (!$this->roleHasPermission($user->role, $permission)) {
            abort(403, 'Unauthorized action. You do not have permission to access this.');
        }
        return $next($request);
    }

    /**
     * Check if the role has the specific permission.
     *
     * @param Role $role
     * @param string $requiredPermission
     * @return bool
     */
    protected function roleHasPermission(Role $role, string $requiredPermission): bool
    {
        return $role && $role->permissions->contains('name', $requiredPermission);
    }
}
