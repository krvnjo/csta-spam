<?php

namespace App\Http\Middleware;

use App\Models\RolePermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
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

        $rolePermission = RolePermission::where('role_id', $user->role_id)
            ->whereHas('permission', function ($query) use ($permission) {
                $query->where('name', $permission);
            })->first();

        if (!$rolePermission) {
            abort(403);
        }

        return $next($request);
    }
}
