<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\PropertyChildController;
use App\Http\Controllers\PropertyParentController;
use App\Http\Controllers\RecycleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SystemSettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ============ Guest Routes ============ //

Route::middleware(['guest', 'noCache'])->group(function () {
    // Login Routes
    Route::name('auth.')->controller(AuthController::class)->group(function () {
        Route::get('/login', 'index')->name('index');
        Route::post('/login', 'login')->name('login');
        Route::get('/forgot-password', 'forgot')->name('forgot');
        Route::post('/forgot-password', 'reset')->name('reset');
    });
});

// ============ End Guest Routes ============ //

// ============ Auth Routes ============ //

Route::middleware(['auth', 'noCache'])->group(function () {
    // Logout Routes
    Route::name('auth.')->controller(AuthController::class)->group(function () {
        Route::get('/logout', 'index')->name('index');
        Route::post('/logout', 'logout')->name('logout');
    });

    // ============ Header Routes ============ //

    // Dashboard Routes
    Route::name('dashboard.')->controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    // Account Routes
    Route::prefix('account')->name('account.')->controller(AccountController::class)->group(function () {
        Route::get('/{username}', 'index')->name('index');
        Route::patch('/{username}', 'update')->name('update');
    });

    // Help & Support Routes
    Route::prefix('help-support')->name('help.')->controller(HelpController::class)->group(function () {
        Route::get('/about', 'about')->name('about');
        Route::get('/guide', 'guide')->name('guide');
    });

    // ============ End Header Routes ============ //

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

    // ============ End Item Inventory Management Routes ============ //

    // ============ User Management Routes ============ //

    // User Routes
    Route::middleware('checkPermission:view user management')->prefix('user-management/users')->name('user.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create user management');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update user management');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete user management');
    });

    // Role Routes
    Route::middleware('checkPermission:view role management')->prefix('user-management/roles')->name('role.')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create role management');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update role management');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete role management');
    });

    // ============ End User Management Routes ============ //

    // ============ File Maintenance Routes ============ //

    // Brand Routes
    Route::middleware('checkPermission:view brand maintenance')->prefix('file-maintenance/brands')->name('brand.')->controller(BrandController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('create')->middleware('checkPermission:create brand maintenance');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update brand maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete brand maintenance');
    });

    // Category Routes
    Route::middleware('checkPermission:view category maintenance')->prefix('file-maintenance/categories')->name('category.')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create category maintenance');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update category maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete category maintenance');
    });

    // Condition Routes
    Route::middleware('checkPermission:view condition maintenance')->prefix('file-maintenance/conditions')->name('condition.')->controller(ConditionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create condition maintenance');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update condition maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete condition maintenance');
    });

    // Department Routes
    Route::middleware('checkPermission:view department maintenance')->prefix('file-maintenance/departments')->name('department.')->controller(DepartmentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create department maintenance');
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
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('checkPermission:create subcategory maintenance');
        Route::patch('/', 'update')->name('update')->middleware('checkPermission:update subcategory maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('checkPermission:delete subcategory maintenance');
    });

    // ============ End File Maintenance Routes ============ //

    // ============ Other Routes ============ //

    // Audit History Routes
    Route::middleware('checkPermission:view audit history')->prefix('audit-history')->name('audit.')->controller(AuditController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
    });

    // System Settings Routes
    Route::middleware('checkPermission:view system settings')->prefix('system-settings')->name('system.')->controller(SystemSettingsController::class)->group(function () {
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
