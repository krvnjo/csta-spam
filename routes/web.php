<?php

use App\Http\Controllers\AcquisitionController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\PropertyParentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ============ Dashboard Routes ============ //
Route::get('/', function () {
    return view('pages.dashboard.index');
});
// ============ End Dashboard Routes ============ //

// ============ Property & Assets Routes ============ //

// Property Parent Routes
Route::controller(PropertyParentController::class)->group(function () {
    Route::get('/properties-assets/overview', 'index')->name('prop-asset.index');
});

// ============ End Property & Assets Routes ============ //

// ============ User Management Routes ============ //

// User Routes
Route::prefix('user-management/users')->name('user.')->controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::patch('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('delete');
});

// Roles Routes
Route::prefix('user-management/roles')->name('role.')->controller(RoleController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::patch('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('delete');
});

// Permissions Routes


// ============ End User Management Routes ============ //

// ============ File Maintenance Routes ============ //

// Acquisition Routes
Route::prefix('file-maintenance/acquisitions')->name('acquisition.')->controller(AcquisitionController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::patch('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('delete');
});

// Brand Routes
Route::prefix('file-maintenance/brands')->name('brand.')->controller(BrandController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::patch('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('delete');
});

// Category Routes
Route::prefix('file-maintenance/categories')->name('category.')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::patch('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('delete');
});

// Condition Routes
Route::prefix('file-maintenance/conditions')->name('condition.')->controller(ConditionController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::patch('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('delete');
});

// Department Routes
Route::prefix('file-maintenance/departments')->name('department.')->controller(DepartmentController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::patch('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('delete');
});

// Designation Routes
Route::prefix('file-maintenance/designations')->name('designation.')->controller(DesignationController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::patch('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('delete');
});

// Subcategory Routes
Route::prefix('file-maintenance/subcategories')->name('subcategory.')->controller(SubcategoryController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::patch('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('delete');
});

// Status Routes
Route::prefix('file-maintenance/statuses')->name('status.')->controller(StatusController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::patch('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('delete');
});

// ============ End File Maintenance Routes ============ //
