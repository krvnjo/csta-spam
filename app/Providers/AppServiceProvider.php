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
        Blade::directive('can', function ($expression) {
            return "<?php if(Auth::check() && Auth::user()->role && {$this->buildPermissionCheck($expression)}): ?>";
        });

        Blade::directive('endcan', function () {
            return "<?php endif; ?>";
        });
    }

    /**
     * Build the permission check logic dynamically based on the expression.
     *
     * @param string $expression
     * @return string
     */
    protected function buildPermissionCheck(string $expression): string
    {
        preg_match('/([^&|]+)(&&|\|\|)?([^&|]*)/', $expression, $matches);

        $permission1 = trim($matches[1]);
        $operator = isset($matches[2]) ? trim($matches[2]) : '||';
        $permission2 = isset($matches[3]) ? trim($matches[3]) : '';

        $permissionCheck = "Auth::user()->role->permissions->pluck('name')->contains({$permission1})";

        if (!empty($permission2)) {
            $permissionCheck .= " {$operator} Auth::user()->role->permissions->pluck('name')->contains({$permission2})";
        }

        return $permissionCheck;
    }
}
