<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Department;
use App\Models\Designation;
use App\Models\MaintenanceTicket;
use App\Models\Requester;
use App\Models\Role;
use App\Models\User;
use App\Observers\BrandObserver;
use App\Observers\CategoryObserver;
use App\Observers\DepartmentObserver;
use App\Observers\DesignationObserver;
use App\Observers\RequesterObserver;
use App\Observers\RoleObserver;
use App\Observers\TicketRequestObserver;
use App\Observers\UserObserver;
use App\Services\AccessService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AccessService::class, function () {
            return new AccessService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('access', function ($expression) {
            return "<?php if(app('App\\Services\\AccessService')->hasAccess($expression)): ?>";
        });

        Blade::directive('endaccess', function () {
            return "<?php endif; ?>";
        });

        MaintenanceTicket::observe(TicketRequestObserver::class);
        User::observe(UserObserver::class);
        Role::observe(RoleObserver::class);
        Brand::observe(BrandObserver::class);
        Category::observe(CategoryObserver::class);
        Department::observe(DepartmentObserver::class);
        Designation::observe(DesignationObserver::class);
        Requester::observe(RequesterObserver::class);
    }
}
