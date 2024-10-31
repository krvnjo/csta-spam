<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

        $permissions = Cache::remember("role_permissions_$user->role_id", 3600, function () use ($user) {
            return $user->role->permissions->pluck('name')->toArray();
        });

        if (!in_array($permission, $permissions)) {
            abort(403);
        }

        return $next($request);
    }
}
