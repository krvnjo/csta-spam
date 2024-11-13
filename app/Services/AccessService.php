<?php

namespace App\Services;

use App\Models\RolePermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AccessService
{
    protected const CACHE_TTL = 3600;

    public function hasAccess($permissionName, $requiredLevels): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        $userRoleId = $user->role_id;
        $accessLevels = array_map('trim', explode(',', $requiredLevels));

        $cacheKey = "role_permissions.{$userRoleId}";

        $permissions = $this->getPermissionsFromCache($cacheKey, $userRoleId);

        if (isset($permissions[$permissionName])) {
            $userAccessLevel = $permissions[$permissionName];
            return in_array($userAccessLevel, $accessLevels);
        }

        return false;
    }

    protected function getPermissionsFromCache(string $cacheKey, int $roleId): array
    {
        static $permissionsCache = [];

        if (!isset($permissionsCache[$roleId])) {
            $permissionsCache[$roleId] = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($roleId) {
                return $this->getRolePermissions($roleId);
            });
        }

        return $permissionsCache[$roleId];
    }

    protected function getRolePermissions($roleId): array
    {
        $rolePermissions = RolePermission::with('role', 'permission', 'access')
            ->where('role_id', $roleId)
            ->get();

        $permissions = [];
        foreach ($rolePermissions as $rolePermission) {
            $permissions[$rolePermission->permission->name] = $rolePermission->access->name ?? null;
        }

        return $permissions;
    }
}

