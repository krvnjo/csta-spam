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
     * @param string $defaultAction
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $defaultAction): mixed
    {
        $user = Auth::user();

        $requiredPermissions = $this->getRequiredPermissions($request->route()->getName());

        $user->load(['role.permissions' => function ($query) use ($requiredPermissions) {
            $query->whereIn('name', $requiredPermissions);
        }]);

        if (!$this->roleHasAnyPermission($user->role, $requiredPermissions)) {
            abort(403, 'Unauthorized action. You do not have permission to access this.');
        }

        return $next($request);
    }

    /**
     * Get the required permissions array based on the route name.
     *
     * @param string $routeName
     * @return array
     */
    protected function getRequiredPermissions(string $routeName): array
    {
        $permissionGroups = [
            'item' => 'item inventory management',
            'user' => 'user management',
            'role' => 'role management',
            'brand' => 'brand maintenance',
            'category' => 'category maintenance',
            'condition' => 'condition maintenance',
            'department' => 'department maintenance',
            'designation' => 'designation maintenance',
            'status' => 'status maintenance',
            'subcategory' => 'subcategory maintenance',
            'audit' => 'audit history',
            'system' => 'system settings',
            'recycle' => 'recycle bin',
        ];

        $actionMappings = ['view', 'create', 'update', 'delete'];

        $routeSegments = explode('.', $routeName);

        $resource = $routeSegments[0] ?? 'view';

        $group = $permissionGroups[$resource] ?? $resource;

        return array_map(fn($action) => "{$action} {$group}", $actionMappings);
    }

    /**
     * Check if the role has any of the specified permissions.
     *
     * @param Role $role
     * @param array $permissions
     * @return bool
     */
    protected function roleHasAnyPermission(Role $role, array $permissions): bool
    {
        return $role && $role->permissions->pluck('name')->intersect($permissions)->isNotEmpty();
    }
}
