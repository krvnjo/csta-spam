<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        Blade::directive('can', function ($permission) {
            return "<?php if (auth()->check() && auth()->user()->hasPermissionTo($permission)): ?>";
        });

        Blade::directive('endcan', function () {
            return '<?php endif; ?>';
        });
    }
}
