<?php

use App\Http\Controllers\AcquisitionController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
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
Route::controller(PropertyParentController::class)->group(function () {
    Route::get('/properties-assets/overview', 'index')->name('prop-asset.index');
    Route::post('/properties-assets/overview/create', 'store')->name('prop-asset.store');
});

// ============ End Property & Assets Routes ============ //

// ============ User Management Routes ============ //

// User Routes
Route::prefix('user-management/users')->name('user.')->controller(UserController::class)->group(function () {
    Route::resource('/', UserController::class);
});

// Roles Routes
Route::prefix('user-management/roles')->name('role.')->controller(RoleController::class)->group(function () {
    Route::resource('/', RoleController::class);
});

// Permissions Routes


// ============ End User Management Routes ============ //

// ============ File Maintenance Routes ============ //

// Acquisition Routes
Route::prefix('file-maintenance/acquisitions')->name('acquisition.')->controller(AcquisitionController::class)->group(function () {
    Route::resource('/', AcquisitionController::class);
});

// Brand Routes
Route::prefix('file-maintenance/brands')->name('brand.')->controller(BrandController::class)->group(function () {
    Route::resource('/', BrandController::class);
});

// Category Routes
Route::prefix('file-maintenance/categories')->name('category.')->controller(CategoryController::class)->group(function () {
    Route::resource('/', CategoryController::class);
});

// Condition Routes
Route::prefix('file-maintenance/conditions')->name('condition.')->controller(ConditionController::class)->group(function () {
    Route::resource('/', ConditionController::class);
});

// Department Routes
Route::prefix('file-maintenance/departments')->name('department.')->controller(DepartmentController::class)->group(function () {
    Route::resource('/', DepartmentController::class);
});

// Designation Routes
Route::prefix('file-maintenance/designations')->name('designation.')->controller(DesignationController::class)->group(function () {
    Route::resource('/', DesignationController::class);
});

// Subcategory Routes
Route::prefix('file-maintenance/subcategories')->name('subcategory.')->controller(SubcategoryController::class)->group(function () {
    Route::resource('/', SubcategoryController::class);
});

// Status Routes
Route::prefix('file-maintenance/statuses')->name('status.')->controller(StatusController::class)->group(function () {
    Route::resource('/', StatusController::class);
});

// ============ End File Maintenance Routes ============ //
