<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowingLogsController;
use App\Http\Controllers\BorrowingRequestController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ItemTransactionController;
use App\Http\Controllers\OngoingBorrowController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PropertyChildController;
use App\Http\Controllers\PropertyOverviewController;
use App\Http\Controllers\PropertyParentController;
use App\Http\Controllers\RequesterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\TicketHistoryController;
use App\Http\Controllers\TicketOngoingController;
use App\Http\Controllers\TicketRequestController;
use App\Http\Controllers\TransactionLogsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ============ Guest Routes ============ //

Route::middleware(['guest', 'noCache'])->group(function () {
    // Login Routes
    Route::prefix('login')->name('auth.')->controller(AuthController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'login')->name('login');
    });

    // Password Reset Routes
    Route::name('password.')->controller(PasswordController::class)->group(function () {
        Route::get('/forgot-password', 'forgot_index')->name('request');
        Route::post('/forgot-password', 'forgot')->name('email');
        Route::get('/reset-password/{token}', 'reset_index')->name('reset');
        Route::post('/reset-password/{token}', 'reset')->name('update');
        Route::get('/change-password/{token}', 'change_index')->name('change');
        Route::post('/change-password/{token}', 'change')->name('expire');
    });
});

// ============ End Guest Routes ============ //

// ============ Auth Routes ============ //

Route::middleware(['auth', 'noCache', 'checkAuth'])->group(function () {
    // Logout Routes
    Route::prefix('logout')->name('auth.')->controller(AuthController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'logout')->name('logout');
    });

    // Account Routes
    Route::prefix('account')->name('account.')->controller(AccountController::class)->group(function () {
        Route::get('/{username}', 'index')->name('index');
        Route::patch('/{username}', 'update')->name('update');
    });

    // Help Resources Routes
    Route::prefix('help-resources')->name('help.')->controller(HelpController::class)->group(function () {
        Route::get('/about-us', 'about')->name('about');
        Route::get('/user-guide', 'guide')->name('guide');
    });

    // ============ Dashboard Routes ============ //

    // Main Dashboard Routes
    Route::name('dashboard.')->controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    // ============ End Dashboard Routes ============ //

    // ============ Item Management Routes ============ //

    // Item Parent Stock Routes
    Route::middleware('checkPermission:Item Management')->prefix('properties-assets/stocks')->name('prop-asset.')->controller(PropertyParentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
        Route::fallback(function () {
            abort(404);
        });
    });

    // Item Child Stock Routes
    Route::middleware('checkPermission:Item Management')->prefix('properties-assets/{propertyParent}/child-stocks')->name('prop-asset.child.')->controller(PropertyChildController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
        Route::patch('/move', 'move')->name('move');
        Route::patch('/dispose', 'dispose')->name('dispose');
        Route::patch('/missing', 'missing')->name('missing');
        Route::get('/turn', 'turn')->name('turn');
        Route::patch('/return', 'return')->name('return');
        Route::get('/generate-qr/{id}', 'generate')->name('generate');
        Route::fallback(function () {
            abort(404);
        });
    });

    // Item Overview Routes
    Route::middleware('checkPermission:Item Management')->prefix('properties-assets/overview')->name('prop-overview.')->controller(PropertyOverviewController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
        Route::fallback(function () {
            abort(404);
        });
    });
    // ============ End Item Management Routes ============ //

    // ============ Borrow & Reservation Routes ============ //

    // New Request Routes
    Route::middleware('checkPermission:Borrow & Reservation')->prefix('borrow-reservation/new-requests')->name('new-request.')->controller(BorrowingRequestController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::patch('/release', 'release')->name('release');
        Route::delete('/', 'destroy')->name('delete');
        Route::fallback(function () {
            abort(404);
        });
    });

    // Ongoing Borrowings Routes
    Route::middleware('checkPermission:Borrow & Reservation')->prefix('borrow-reservation/ongoing-borrows')->name('ongoing-borrow.')->controller(OngoingBorrowController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
        Route::fallback(function () {
            abort(404);
        });
    });

    // Borrowing Logs Routes
    Route::middleware('checkPermission:Borrow & Reservation')->prefix('borrow-reservation/borrow-logs')->name('borrow-logs.')->controller(BorrowingLogsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
        Route::fallback(function () {
            abort(404);
        });
    });

    // Transaction Logs Routes
    Route::middleware('checkPermission:Borrow & Reservation')->prefix('borrow-reservation/transaction-logs')->name('transaction-logs.')->controller(TransactionLogsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
        Route::fallback(function () {
            abort(404);
        });
    });

    Route::middleware('checkPermission:Borrow & Reservation')->prefix('item-transactions/new-transaction')->name('new-transaction.')->controller(ItemTransactionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::patch('/release', 'release')->name('release');
        Route::delete('/', 'destroy')->name('delete');
        Route::fallback(function () {
            abort(404);
        });
    });

    // ============ End Borrow & Reservation Routes ============ //

    // ============ Repair & Maintenance Routes ============ //

    // Ticket Requests Routes
    Route::middleware('checkPermission:Repair & Maintenance')->prefix('repair-maintenance/ticket-requests')->name('request.')->controller(TicketRequestController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // Ongoing Maintenance Routes
    Route::middleware('checkPermission:Repair & Maintenance')->prefix('repair-maintenance/ongoing-maintenance')->name('ongoing.')->controller(TicketOngoingController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
    });

    // Maintenance History Routes
    Route::middleware('checkPermission:Repair & Maintenance')->prefix('repair-maintenance/maintenance-history')->name('history.')->controller(TicketHistoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
    });

    // ============ End Repair & Maintenance Routes ============ //

    // ============ User Management Routes ============ //

    // User Routes
    Route::middleware('checkPermission:User Management')->prefix('user-management/users')->name('user.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // Role Routes
    Route::middleware('checkPermission:User Management')->prefix('user-management/roles')->name('role.')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // ============ End User Management Routes ============ //

    // ============ File Maintenance Routes ============ //

    // Brand Routes
    Route::middleware('checkPermission:File Maintenance')->prefix('file-maintenance/brands')->name('brand.')->controller(BrandController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // Category Routes
    Route::middleware('checkPermission:File Maintenance')->prefix('file-maintenance/categories')->name('category.')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // Department Routes
    Route::middleware('checkPermission:File Maintenance')->prefix('file-maintenance/departments')->name('department.')->controller(DepartmentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // Designation Routes
    Route::middleware('checkPermission:File Maintenance')->prefix('file-maintenance/designations')->name('designation.')->controller(DesignationController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // Requester Routes
    Route::middleware('checkPermission:File Maintenance')->prefix('file-maintenance/requesters')->name('requester.')->controller(RequesterController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('create');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
        Route::get('/edit', 'edit')->name('edit')->middleware('expectsJson');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('delete');
    });

    // ============ End File Maintenance Routes ============ //

    // ============ Other Routes ============ //

    // Audit History Routes
    Route::middleware('checkPermission:Audit History')->prefix('audit-history')->name('audit.')->controller(AuditController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/view', 'show')->name('view')->middleware('expectsJson');
    });

    // System Settings Routes
    Route::middleware('checkPermission:System Settings')->prefix('system-settings')->name('system.')->controller(SystemController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::patch('/', 'update')->name('update');
    });

    // ============ End Other Routes ============ //
});

// ============ End Auth Routes ============ //
