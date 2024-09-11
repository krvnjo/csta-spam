<?php

use App\Http\Controllers\AcquisitionController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\PropertyParentController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SubcategoryController;
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
    Route::post('/properties-assets/overview/create', 'store')->name('prop-asset.store');
});


// ============ End Property & Assets Routes ============ //

// ============ File Maintenance Routes ============ //

// Acquisition Routes
Route::controller(AcquisitionController::class)->group(function () {
    Route::get('/file-maintenance/acquisitions', 'index')->name('acquisition.index');
    Route::post('/file-maintenance/acquisitions/create', 'store')->name('acquisition.store');
    Route::get('/file-maintenance/acquisitions/edit', 'edit')->name('acquisition.edit');
    Route::patch('/file-maintenance/acquisitions/update', 'update')->name('acquisition.update');
    Route::delete('/file-maintenance/acquisitions/delete', 'destroy')->name('acquisition.delete');
});

// Brand Routes
Route::controller(BrandController::class)->group(function () {
    Route::get('/file-maintenance/brands', 'index')->name('brand.index');
});

// Category Routes
Route::controller(CategoryController::class)->group(function () {
    Route::get('/file-maintenance/categories', 'index')->name('category.index');
});

// Condition Routes
Route::controller(ConditionController::class)->group(function () {
    Route::get('/file-maintenance/conditions', 'index')->name('condition.index');
});

// Department Routes
Route::controller(DepartmentController::class)->group(function () {
    Route::get('/file-maintenance/departments', 'index')->name('department.index');
});

// Designation Routes
Route::controller(DesignationController::class)->group(function () {
    Route::get('/file-maintenance/designations', 'index')->name('designation.index');
});

// Subcategory Routes
Route::controller(SubcategoryController::class)->group(function () {
    Route::get('/file-maintenance/subcategories', 'index')->name('subcategory.index');
});

// Statuses Routes
Route::controller(StatusController::class)->group(function () {
    Route::get('/file-maintenance/statuses', 'index')->name('status.index');
});

// ============ End File Maintenance Routes ============ //
