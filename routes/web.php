<?php

use App\Http\Controllers\AcquisitionController;
use App\Http\Controllers\DepartmentController;
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

// Department Routes
Route::controller(DepartmentController::class)->group(function () {
    Route::get('/file-maintenance/departments', 'index')->name('department.index');
});

// ============ End File Maintenance Routes ============ //
