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
    Route::post('/file-maintenance/brands/create', 'store')->name('brand.store');
    Route::get('/file-maintenance/brands/edit', 'edit')->name('brand.edit');
    Route::patch('/file-maintenance/brands/update', 'update')->name('brand.update');
    Route::delete('/file-maintenance/brands/delete', 'destroy')->name('brand.delete');
});

// Category Routes
Route::controller(CategoryController::class)->group(function () {
    Route::get('/file-maintenance/categories', 'index')->name('category.index');
    Route::post('/file-maintenance/categories/create', 'store')->name('category.store');
    Route::get('/file-maintenance/categories/edit', 'edit')->name('category.edit');
    Route::patch('/file-maintenance/categories/update', 'update')->name('category.update');
    Route::delete('/file-maintenance/categories/delete', 'destroy')->name('category.delete');
});

// Condition Routes
Route::controller(ConditionController::class)->group(function () {
    Route::get('/file-maintenance/conditions', 'index')->name('condition.index');
    Route::post('/file-maintenance/conditions/create', 'store')->name('condition.store');
    Route::get('/file-maintenance/conditions/edit', 'edit')->name('condition.edit');
    Route::patch('/file-maintenance/conditions/update', 'update')->name('condition.update');
    Route::delete('/file-maintenance/conditions/delete', 'destroy')->name('condition.delete');
});

// Department Routes
Route::controller(DepartmentController::class)->group(function () {
    Route::get('/file-maintenance/departments', 'index')->name('department.index');
    Route::post('/file-maintenance/departments/create', 'store')->name('department.store');
    Route::get('/file-maintenance/departments/edit', 'edit')->name('department.edit');
    Route::patch('/file-maintenance/departments/update', 'update')->name('department.update');
    Route::delete('/file-maintenance/departments/delete', 'destroy')->name('department.delete');
});

// Designation Routes
Route::controller(DesignationController::class)->group(function () {
    Route::get('/file-maintenance/designations', 'index')->name('designation.index');
    Route::post('/file-maintenance/designations/create', 'store')->name('designation.store');
    Route::get('/file-maintenance/designations/edit', 'edit')->name('designation.edit');
    Route::patch('/file-maintenance/designations/update', 'update')->name('designation.update');
    Route::delete('/file-maintenance/designations/delete', 'destroy')->name('designation.delete');
});

// Subcategory Routes
Route::controller(SubcategoryController::class)->group(function () {
    Route::get('/file-maintenance/subcategories', 'index')->name('subcategory.index');
    Route::post('/file-maintenance/subcategories/create', 'store')->name('subcategory.store');
    Route::get('/file-maintenance/subcategories/edit', 'edit')->name('subcategory.edit');
    Route::patch('/file-maintenance/subcategories/update', 'update')->name('subcategory.update');
    Route::delete('/file-maintenance/subcategories/delete', 'destroy')->name('subcategory.delete');
});

// Statuses Routes
Route::controller(StatusController::class)->group(function () {
    Route::get('/file-maintenance/statuses', 'index')->name('status.index');
    Route::post('/file-maintenance/statuses/create', 'store')->name('status.store');
    Route::get('/file-maintenance/statuses/edit', 'edit')->name('status.edit');
    Route::patch('/file-maintenance/statuses/update', 'update')->name('status.update');
    Route::delete('/file-maintenance/statuses/delete', 'destroy')->name('status.delete');
});

// ============ End File Maintenance Routes ============ //
