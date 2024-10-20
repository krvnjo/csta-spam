<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuditHistoryController;
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

Route::middleware(['guest', 'nocache'])->group(function () {
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

Route::middleware(['auth', 'nocache'])->group(function () {
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
    Route::middleware('can:view item management')->prefix('properties-assets/stocks')->name('prop-asset.')->controller(PropertyParentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/create', 'store')->name('store');
        Route::get('/show', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::patch('/update', 'update')->name('update');
        Route::delete('/delete', 'destroy')->name('delete');
        Route::get('/get-subcategory-brands', 'getSubcategoryBrands')->name('getSubcategoryBrands');
    });
    Route::middleware('can:view item management')->prefix('properties-assets/{propertyParent}/child-stocks')->name('prop-asset.child.')->controller(PropertyChildController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/create', 'store')->name('store');
        Route::get('/edit', 'edit')->name('edit');
        Route::patch('/update', 'update')->name('update');
        Route::delete('/delete', 'destroy')->name('delete');
    });

    // ============ End Item Inventory Management Routes ============ //

    // ============ User Management Routes ============ //

    // User Routes
    Route::middleware('can:view user management')->prefix('user-management/users')->name('user.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('can:create user management');
        Route::patch('/', 'update')->name('update')->middleware('can:update user management');
        Route::delete('/', 'destroy')->name('delete')->middleware('can:delete user management');
    });

    // Role Routes
    Route::middleware('can:view role management')->prefix('user-management/roles')->name('role.')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('can:create role management');
        Route::patch('/', 'update')->name('update')->middleware('can:update role management');
        Route::delete('/', 'destroy')->name('delete')->middleware('can:delete role management');
    });

    // ============ End User Management Routes ============ //

    // ============ File Maintenance Routes ============ //

    // Brand Routes
    Route::middleware('can:view brand maintenance')->prefix('file-maintenance/brands')->name('brand.')->controller(BrandController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('can:create brand maintenance');
        Route::patch('/', 'update')->name('update')->middleware('can:update brand maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('can:delete brand maintenance');
    });

    // Category Routes
    Route::middleware('can:view category maintenance')->prefix('file-maintenance/categories')->name('category.')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('can:create category maintenance');
        Route::patch('/', 'update')->name('update')->middleware('can:update category maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('can:delete category maintenance');
    });

    // Condition Routes
    Route::middleware('can:view condition maintenance')->prefix('file-maintenance/conditions')->name('condition.')->controller(ConditionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('can:create condition maintenance');
        Route::patch('/', 'update')->name('update')->middleware('can:update condition maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('can:delete condition maintenance');
    });

    // Department Routes
    Route::middleware('can:view department maintenance')->prefix('file-maintenance/departments')->name('department.')->controller(DepartmentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('can:create department maintenance');
        Route::patch('/', 'update')->name('update')->middleware('can:update department maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('can:delete department maintenance');
    });

    // Designation Routes
    Route::middleware('can:view designation maintenance')->prefix('file-maintenance/designations')->name('designation.')->controller(DesignationController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('can:create designation maintenance');
        Route::patch('/', 'update')->name('update')->middleware('can:update designation maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('can:delete designation maintenance');
    });

    // Status Routes
    Route::middleware('can:view status maintenance')->prefix('file-maintenance/statuses')->name('status.')->controller(StatusController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('can:create status maintenance');
        Route::patch('/', 'update')->name('update')->middleware('can:update status maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('can:delete status maintenance');
    });

    // Subcategory Routes
    Route::middleware('can:view subcategory maintenance')->prefix('file-maintenance/subcategories')->name('subcategory.')->controller(SubcategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('can:create subcategory maintenance');
        Route::patch('/', 'update')->name('update')->middleware('can:update subcategory maintenance');
        Route::delete('/', 'destroy')->name('delete')->middleware('can:delete subcategory maintenance');
    });

    // ============ End File Maintenance Routes ============ //

    // ============ Other Routes ============ //

    // Audit History Routes
    Route::middleware('can:view audit history')->prefix('audit-history')->name('audit.')->controller(AuditHistoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
    });

    // System Settings Routes
    Route::middleware('can:view system settings')->prefix('system-settings')->name('system.')->controller(SystemSettingsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::patch('/', 'update')->name('update')->middleware('can:update system settings');
    });

    // Recycle Bin Routes
    Route::middleware('can:view recycle bin')->prefix('recycle-bin')->name('recycle.')->controller(RecycleController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::patch('/', 'update')->name('update')->middleware('can:update recycle bin');
    });

    // ============ End Other Routes ============ //
});

// ============ End Auth Routes ============ //
