<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $permission
     * @param $action
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission, $action): Response
    {
        $user = Auth::user();
        $role = $user->roles()->first();

        $hasPermission = \DB::table('role_has_permissions')
            ->where('role_id', $role->id)
            ->where('permission_id', Permission::query()->where('name', $permission)->value('id'))
            ->first();

        if ($hasPermission && $hasPermission->{'can_' . $action}) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
