<?php

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
