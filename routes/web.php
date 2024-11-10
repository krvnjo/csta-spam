<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\ConsumptionLogsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PropertyChildController;
use App\Http\Controllers\PropertyConsumableController;
use App\Http\Controllers\PropertyInvChildController;
use App\Http\Controllers\PropertyInventoryController;
use App\Http\Controllers\PropertyParentController;
use App\Http\Controllers\RecycleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ============ Guest Routes ============ //

Route::middleware(['guest', 'noCache'])->group(function () {
    // Login Routes
    Route::prefix('login')->name('auth.')->controller(AuthController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'login')->name('login');
    });

    // Password Reset Routes
    Route::name('password.')->controller(PasswordController::class)->group(function () {
        Route::get('/forgot-password', 'forgot_index')->name('request');
        Route::post('/forgot-password', 'forgot')->name('email');
        Route::get('/reset-password/{token}', 'reset_index')->name('reset');
        Route::post('/reset-password/{token}', 'reset')->name('update');
    });
});

// ============ End Guest Routes ============ //

// ============ Auth Routes ============ //

Route::middleware(['auth', 'noCache', 'checkAuth'])->group(function () {
    // Logout Routes
    Route::prefix('logout')->name('auth.')->controller(AuthController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'logout')->name('logout');
    });

    // Account Routes
    Route::prefix('account')->name('account.')->controller(AccountController::class)->group(function () {
        Route::get('/{username}', 'index')->name('index');
        Route::patch('/{username}', 'update')->name('update');
    });

    // Help Resources Routes
    Route::prefix('help-resources')->name('help.')->controller(HelpController::class)->group(function () {
        Route::get('/about-us', 'about')->name('about');
        Route::get('/user-guide', 'guide')->name('guide');
    });

    // ============ Dashboard Routes ============ //

    // Main Dashboard Routes
    Route::name('dashboard.')->controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    // ============ End Dashboard Routes ============ //

    // ============ Item Inventory Management Routes ============ //

    // Stock Routes
    Route::middleware('checkPermission:view item management')->prefix('properties-assets/stocks')->name('prop-asset.')->controller(PropertyParentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create item management');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update item management');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete item management');
        Route::get('/get-subcategory-brands', 'getSubcategoryBrands')->name('getSubcategoryBrands')->middleware('expectsJson');
        Route::fallback(function () {
            abort(404);
        });
    });
    Route::middleware('checkPermission:view item management')->prefix('properties-assets/{propertyParent}/child-stocks')->name('prop-asset.child.')->controller(PropertyChildController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create item management');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update item management');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete item management');
        Route::patch('/move', 'move')->name('move')->middleware('checkPermission:update item management');
        Route::fallback(function () {
            abort(404);
        });
    });

    // Inventory Routes
    Route::middleware('checkPermission:view item management')->prefix('properties-assets/inventory')->name('prop-inv.')->controller(PropertyInventoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create item management');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update item management');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete item management');
        Route::fallback(function () {
            abort(404);
        });
    });

    Route::middleware('checkPermission:view item management')->prefix('properties-assets/{propertyParent}/child-inventory')->name('prop-inv.child.')->controller(PropertyInvChildController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create item management');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update item management');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete item management');
        Route::patch('/move', 'move')->name('move')->middleware('checkPermission:update item management');
        Route::fallback(function () {
            abort(404);
        });
    });

    // Consumable Routes
    Route::middleware('checkPermission:view item management')->prefix('properties-assets/consumable')->name('prop-consumable.')->controller(PropertyConsumableController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create item management');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update item management');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete item management');
        Route::patch('/restock', 'restock')->name('restock')->middleware('checkPermission:update item management');
        Route::patch('/use', 'use')->name('use')->middleware('checkPermission:update item management');
        Route::fallback(function () {
            abort(404);
        });
    });

    // Consumption Routes
    Route::middleware('checkPermission:view item management')->prefix('properties-assets/consumption-logs')->name('prop-consumption.')->controller(ConsumptionLogsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create item management');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update item management');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete item management');
        Route::fallback(function () {
            abort(404);
        });
    });

    // ============ End Item Inventory Management Routes ============ //

    // ============ User Management Routes ============ //

    // User Routes
    Route::middleware('checkPermission:view user management')->prefix('user-management/users')->name('user.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create')->middleware('checkPermission:create user management');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update user management');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete user management');
    });

    // Role Routes
    Route::middleware('checkPermission:view role management')->prefix('user-management/roles')->name('role.')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create')->middleware('checkPermission:create role management');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update role management');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete role management');
    });

    // ============ End User Management Routes ============ //

    // ============ File Maintenance Routes ============ //

    // Brand Routes
    Route::middleware('checkPermission:view brand maintenance')->prefix('file-maintenance/brands')->name('brand.')->controller(BrandController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create')->middleware('checkPermission:create brand maintenance');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update brand maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete brand maintenance');
    });

    // Category Routes
    Route::middleware('checkPermission:view category maintenance')->prefix('file-maintenance/categories')->name('category.')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create')->middleware('checkPermission:create category maintenance');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update category maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete category maintenance');
    });

    // Condition Routes
    Route::middleware('checkPermission:view condition maintenance')->prefix('file-maintenance/conditions')->name('condition.')->controller(ConditionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create')->middleware('checkPermission:create condition maintenance');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update condition maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete condition maintenance');
    });

    // Department Routes
    Route::middleware('checkPermission:view department maintenance')->prefix('file-maintenance/departments')->name('department.')->controller(DepartmentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create')->middleware('checkPermission:create department maintenance');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update department maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete department maintenance');
    });

    // Designation Routes
    Route::middleware('checkPermission:view designation maintenance')->prefix('file-maintenance/designations')->name('designation.')->controller(DesignationController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create designation maintenance');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update designation maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete designation maintenance');
    });

    // Status Routes
    Route::middleware('checkPermission:view status maintenance')->prefix('file-maintenance/statuses')->name('status.')->controller(StatusController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create status maintenance');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update status maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete status maintenance');
    });

    // Subcategory Routes
    Route::middleware('checkPermission:view subcategory maintenance')->prefix('file-maintenance/subcategories')->name('subcategory.')->controller(SubcategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create')->middleware('checkPermission:create subcategory maintenance');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update subcategory maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete subcategory maintenance');
    });

    // ============ End File Maintenance Routes ============ //

    // ============ Other Routes ============ //

    // Audit History Routes
    Route::middleware('checkPermission:view audit history')->prefix('audit-history')->name('audit.')->controller(AuditController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update audit history');
    });

    // System Settings Routes
    Route::middleware('checkPermission:view system settings')->prefix('system-settings')->name('system.')->controller(SystemController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update system settings');
    });

    // Recycle Bin Routes
    Route::middleware('checkPermission:view recycle bin')->prefix('recycle-bin')->name('recycle.')->controller(RecycleController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update recycle bin');
    });

    // ============ End Other Routes ============ //
});

// ============ End Auth Routes ============ //
