<?php

use App\Http\Controllers\AcquisitionController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\PropertyParentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard.index');
});

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

// ============ End File Maintenance Routes ============ //
