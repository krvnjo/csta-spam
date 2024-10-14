<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\PropertyChildController;
use App\Http\Controllers\PropertyParentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ============ Dashboard Routes ============ //

// Admin Dashboard Routes
Route::name('dashboard.')->controller(DashboardController::class)->group(function () {
    Route::resource('/', DashboardController::class);
});

// ============ End Dashboard Routes ============ //

// ============ Property & Assets Routes ============ //

// Property Parent Routes
Route::prefix('properties-assets/stocks')->name('prop-asset.')->controller(PropertyParentController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('store');
    Route::get('/show', 'show')->name('show');
    Route::get('/edit', 'edit')->name('edit');
    Route::patch('/update', 'update')->name('update');
    Route::delete('/delete', 'destroy')->name('delete');
    Route::get('/get-subcategory-brands', 'getSubcategoryBrands')->name('getSubcategoryBrands');
});
Route::prefix('properties-assets/child-stocks')->name('prop-asset.child.')->controller(PropertyChildController::class)->group(function () {
    Route::get('/{id}', 'index')->name('index');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit', 'edit')->name('edit');
    Route::patch('/update', 'update')->name('update');
    Route::delete('/delete', 'destroy')->name('delete');
});

// ============ End Property & Assets Routes ============ //

// ============ User Management Routes ============ //

// User Routes
Route::prefix('user-management/users')->name('user.')->controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store')->middleware('expectsJson');
    Route::get('/show', 'show')->name('show')->middleware('expectsJson');
    Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
    Route::patch('/update', 'update')->name('update')->middleware('expectsJson');
    Route::delete('/delete', 'destroy')->name('delete')->middleware('expectsJson');
});

// Roles Routes
Route::prefix('user-management/roles')->name('role.')->controller(RoleController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store')->middleware('expectsJson');
    Route::get('/show', 'show')->name('show')->middleware('expectsJson');
    Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
    Route::patch('/update', 'update')->name('update')->middleware('expectsJson');
    Route::delete('/delete', 'destroy')->name('delete')->middleware('expectsJson');
});

// Permissions Routes


// ============ End User Management Routes ============ //

// ============ File Maintenance Routes ============ //

// Brand Routes
Route::prefix('file-maintenance/brands')->name('brand.')->controller(BrandController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store')->middleware('expectsJson');
    Route::get('/show', 'show')->name('show')->middleware('expectsJson');
    Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
    Route::patch('/update', 'update')->name('update')->middleware('expectsJson');
    Route::delete('/delete', 'destroy')->name('delete')->middleware('expectsJson');
});

// Category Routes
Route::prefix('file-maintenance/categories')->name('category.')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store')->middleware('expectsJson');
    Route::get('/show', 'show')->name('show')->middleware('expectsJson');
    Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
    Route::patch('/update', 'update')->name('update')->middleware('expectsJson');
    Route::delete('/delete', 'destroy')->name('delete')->middleware('expectsJson');
});

// Condition Routes
Route::prefix('file-maintenance/conditions')->name('condition.')->controller(ConditionController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store')->middleware('expectsJson');
    Route::get('/show', 'show')->name('show')->middleware('expectsJson');
    Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
    Route::patch('/update', 'update')->name('update')->middleware('expectsJson');
    Route::delete('/delete', 'destroy')->name('delete')->middleware('expectsJson');
});

// Department Routes
Route::prefix('file-maintenance/departments')->name('department.')->controller(DepartmentController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store')->middleware('expectsJson');
    Route::get('/show', 'show')->name('show')->middleware('expectsJson');
    Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
    Route::patch('/update', 'update')->name('update')->middleware('expectsJson');
    Route::delete('/delete', 'destroy')->name('delete')->middleware('expectsJson');
});

// Designation Routes
Route::prefix('file-maintenance/designations')->name('designation.')->controller(DesignationController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store')->middleware('expectsJson');
    Route::get('/show', 'show')->name('show')->middleware('expectsJson');
    Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
    Route::patch('/update', 'update')->name('update')->middleware('expectsJson');
    Route::delete('/delete', 'destroy')->name('delete')->middleware('expectsJson');
});

// Status Routes
Route::prefix('file-maintenance/statuses')->name('status.')->controller(StatusController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store')->middleware('expectsJson');
    Route::get('/show', 'show')->name('show')->middleware('expectsJson');
    Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
    Route::patch('/update', 'update')->name('update')->middleware('expectsJson');
    Route::delete('/delete', 'destroy')->name('delete')->middleware('expectsJson');
});

// Subcategory Routes
Route::prefix('file-maintenance/subcategories')->name('subcategory.')->controller(SubcategoryController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store')->middleware('expectsJson');
    Route::get('/show', 'show')->name('show')->middleware('expectsJson');
    Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
    Route::patch('/update', 'update')->name('update')->middleware('expectsJson');
    Route::delete('/delete', 'destroy')->name('delete')->middleware('expectsJson');
});

// ============ End File Maintenance Routes ============ //
