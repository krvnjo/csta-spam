<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
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
use App\Http\Controllers\RoleController;
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
    Route::middleware('checkPermission:Item Inventory Management')->prefix('properties-assets/stocks')->name('prop-asset.')->controller(PropertyParentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
        Route::fallback(function () {
            abort(404);
        });
    });
    Route::middleware('checkPermission:Item Inventory Management')->prefix('properties-assets/{propertyParent}/child-stocks')->name('prop-asset.child.')->controller(PropertyChildController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
        Route::patch('/move', 'move')->name('move');
        Route::get('/generate-qr/{id}', 'generate')->name('generate');
        Route::fallback(function () {
            abort(404);
        });
    });

    // Inventory Routes
    Route::middleware('checkPermission:Item Inventory Management')->prefix('properties-assets/inventory')->name('prop-inv.')->controller(PropertyInventoryController::class)->group(function () {
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
    Route::middleware('checkPermission:Item Inventory Management')->prefix('properties-assets/consumable')->name('prop-consumable.')->controller(PropertyConsumableController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
        Route::patch('/restock', 'restock')->name('restock');
        Route::patch('/use', 'use')->name('use');
        Route::fallback(function () {
            abort(404);
        });
    });

    // Consumption Routes
    Route::middleware('checkPermission:Item Inventory Management')->prefix('properties-assets/consumption-logs')->name('prop-consumption.')->controller(ConsumptionLogsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
        Route::fallback(function () {
            abort(404);
        });
    });

    // ============ End Item Inventory Management Routes ============ //

    // ============ User Management Routes ============ //

    // User Routes
    Route::middleware('checkPermission:User Management')->prefix('user-management/users')->name('user.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // Role Routes
    Route::middleware('checkPermission:Role Management')->prefix('user-management/roles')->name('role.')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // ============ End User Management Routes ============ //

    // ============ File Maintenance Routes ============ //

    // Brand Routes
    Route::middleware('checkPermission:Brand Maintenance')->prefix('file-maintenance/brands')->name('brand.')->controller(BrandController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // Category Routes
    Route::middleware('checkPermission:Category Maintenance')->prefix('file-maintenance/categories')->name('category.')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // Department Routes
    Route::middleware('checkPermission:Department Maintenance')->prefix('file-maintenance/departments')->name('department.')->controller(DepartmentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // Designation Routes
    Route::middleware('checkPermission:Designation Maintenance')->prefix('file-maintenance/designations')->name('designation.')->controller(DesignationController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // ============ End File Maintenance Routes ============ //

    // ============ Other Routes ============ //

    // Audit History Routes
    Route::middleware('checkPermission:Audit History')->prefix('audit-history')->name('audit.')->controller(AuditController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
    });

    // System Settings Routes
    Route::middleware('checkPermission:System Settings')->prefix('system-settings')->name('system.')->controller(SystemController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::patch('/', 'update')->name('update');
    });

    // ============ End Other Routes ============ //
});

// ============ End Auth Routes ============ //
