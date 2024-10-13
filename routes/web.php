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
use App\Http\Controllers\PropertyParentController;
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

    // ============ Inventory Management Routes ============ //

    // Stock Routes
    Route::middleware('check.permission:Inventory Management,view')->prefix('inventory-management/stocks')->name('prop-asset.')->controller(PropertyParentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/create', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::patch('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('delete');
    });

    // ============ End Inventory Management Routes ============ //

    // ============ User Management Routes ============ //

    // User Routes
    Route::middleware('check.permission:User Management,view')->prefix('user-management/users')->name('user.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('check.permission:User Management,create');
        Route::patch('/', 'update')->name('update')->middleware('check.permission:User Management,edit');
        Route::delete('/', 'destroy')->name('delete')->middleware('check.permission:User Management,delete');
    });

    // Role Routes
    Route::middleware('check.permission:Role Management,view')->prefix('user-management/roles')->name('role.')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('check.permission:Role Management,create');
        Route::patch('/', 'update')->name('update')->middleware('check.permission:Role Management,edit');
        Route::delete('/', 'destroy')->name('delete')->middleware('check.permission:Role Management,delete');
    });

    // ============ End User Management Routes ============ //

    // ============ File Maintenance Routes ============ //

    // Brand Routes
    Route::middleware('check.permission:Brand Maintenance,view')->prefix('file-maintenance/brands')->name('brand.')->controller(BrandController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('check.permission:Brand Maintenance,create');
        Route::patch('/', 'update')->name('update')->middleware('check.permission:Brand Maintenance,edit');
        Route::delete('/', 'destroy')->name('delete')->middleware('check.permission:Brand Maintenance,delete');
    });

    // Category Routes
    Route::middleware('check.permission:Category Maintenance,view')->prefix('file-maintenance/categories')->name('category.')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('check.permission:Category Maintenance,create');
        Route::patch('/', 'update')->name('update')->middleware('check.permission:Category Maintenance,edit');
        Route::delete('/', 'destroy')->name('delete')->middleware('check.permission:Category Maintenance,delete');
    });

    // Condition Routes
    Route::middleware('check.permission:Condition Maintenance,view')->prefix('file-maintenance/conditions')->name('condition.')->controller(ConditionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('check.permission:Condition Maintenance,create');
        Route::patch('/', 'update')->name('update')->middleware('check.permission:Condition Maintenance,edit');
        Route::delete('/', 'destroy')->name('delete')->middleware('check.permission:Condition Maintenance,delete');
    });

    // Department Routes
    Route::middleware('check.permission:Department Maintenance,view')->prefix('file-maintenance/departments')->name('department.')->controller(DepartmentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('check.permission:Department Maintenance,create');
        Route::patch('/', 'update')->name('update')->middleware('check.permission:Department Maintenance,edit');
        Route::delete('/', 'destroy')->name('delete')->middleware('check.permission:Department Maintenance,delete');
    });

    // Designation Routes
    Route::middleware('check.permission:Designation Maintenance,view')->prefix('file-maintenance/designations')->name('designation.')->controller(DesignationController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('check.permission:Designation Maintenance,create');
        Route::patch('/', 'update')->name('update')->middleware('check.permission:Designation Maintenance,edit');
        Route::delete('/', 'destroy')->name('delete')->middleware('check.permission:Designation Maintenance,delete');
    });

    // Status Routes
    Route::middleware('check.permission:Status Maintenance,view')->prefix('file-maintenance/statuses')->name('status.')->controller(StatusController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('check.permission:Status Maintenance,create');
        Route::patch('/', 'update')->name('update')->middleware('check.permission:Status Maintenance,edit');
        Route::delete('/', 'destroy')->name('delete')->middleware('check.permission:Status Maintenance,delete');
    });

    // Subcategory Routes
    Route::middleware('check.permission:Subcategory Maintenance,view')->prefix('file-maintenance/subcategories')->name('subcategory.')->controller(SubcategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::post('/', 'store')->name('store')->middleware('check.permission:Subcategory Maintenance,create');
        Route::patch('/', 'update')->name('update')->middleware('check.permission:Subcategory Maintenance,edit');
        Route::delete('/', 'destroy')->name('delete')->middleware('check.permission:Subcategory Maintenance,delete');
    });

    // ============ End File Maintenance Routes ============ //

    // ============ Other Routes ============ //

    // Audit History Routes
    Route::middleware('check.permission:Audit History,view')->prefix('audit-history')->name('audit.')->controller(AuditHistoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show')->middleware('expectsJson');
    });

    // System Settings Routes
    Route::middleware('check.permission:System Settings,view')->prefix('system-settings')->name('system.')->controller(SystemSettingsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::patch('/', 'update')->name('update')->middleware('check.permission:System Settings,edit');
    });

    // ============ End Other Routes ============ //
});

// ============ End Auth Routes ============ //
