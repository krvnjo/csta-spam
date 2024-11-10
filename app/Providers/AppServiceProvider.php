<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use App\Observers\BrandObserver;
use App\Observers\DepartmentObserver;
use App\Observers\DesignationObserver;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app()->singleton('role_permissions', function () {
            $user = Auth::user();
            if (!$user) return [];

            return Cache::remember(
                'role_permissions_' . $user->role_id,
                3600,
                fn() => $user->role->permissions->pluck('name')->toArray()
            );
        });

        Blade::directive('can', function ($permission) {
            return "<?php if (app('auth')->user() && in_array($permission, app()->make('role_permissions'))) : ?>";
        });

        Blade::directive('endcan', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('canAll', function ($permissions) {
            return "<?php if (app('auth')->user() && collect(explode(',', $permissions))->every(fn(\$permission) => in_array(trim(\$permission), app()->make('role_permissions')))) : ?>";
        });

        Blade::directive('endcanAll', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('canAny', function ($permissions) {
            return "<?php if (app('auth')->user() && collect(explode(',', $permissions))->contains(fn(\$permission) => in_array(trim(\$permission), app()->make('role_permissions')))) : ?>";
        });

        Blade::directive('endcanAny', function () {
            return "<?php endif; ?>";
        });

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return url('/reset-password/' . $token);
        });

        Brand::observe(BrandObserver::class);
        Department::observe(DepartmentObserver::class);
        Designation::observe(DesignationObserver::class);
    }
}
