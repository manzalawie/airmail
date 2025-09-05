<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\{
    HscodeController,
    InboundController,
    StoreController,
    VnsController,
    TablesController,
    EmployeeAffairsController,
    DashboardController,
    UserController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Auth routs
Auth::routes(['register' => false]);

Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth:sanctum');
Route::get('/home', [DashboardController::class, 'index'])->name('home')->middleware('auth:sanctum');

// HS Code Module
Route::prefix('hs-code')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [HscodeController::class, 'index'])->name('hs-code.index')->middleware('permission:view-hs-code');
    Route::get('/create', [HscodeController::class, 'create'])->name('hs-code.create')->middleware('permission:create-hs-code');
    Route::post('/', [HscodeController::class, 'store'])->name('hs-code.store')->middleware('permission:create-hs-code');
    Route::get('/{id}/edit', [HscodeController::class, 'edit'])->name('hs-code.edit')->middleware('permission:edit-hs-code');
    Route::put('/{id}', [HscodeController::class, 'update'])->name('hs-code.update')->middleware('permission:edit-hs-code');
    Route::delete('/{id}', [HscodeController::class, 'destroy'])->name('hs-code.destroy')->middleware('permission:delete-hs-code');
    Route::post('/{id}/approve', [HscodeController::class, 'approve'])->name('hs-code.approve')->middleware('permission:approve-hs-code');
});

// Sorting Module
Route::prefix('sorting')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [SortingController::class, 'index'])->name('sorting.index')->middleware('permission:view-sorting');
    Route::get('/create', [SortingController::class, 'create'])->name('sorting.create')->middleware('permission:create-sorting');
    Route::post('/', [SortingController::class, 'store'])->name('sorting.store')->middleware('permission:create-sorting');
    Route::get('/{id}/edit', [SortingController::class, 'edit'])->name('sorting.edit')->middleware('permission:edit-sorting');
    Route::put('/{id}', [SortingController::class, 'update'])->name('sorting.update')->middleware('permission:edit-sorting');
    Route::delete('/{id}', [SortingController::class, 'destroy'])->name('sorting.destroy')->middleware('permission:delete-sorting');
    Route::post('/{id}/approve', [SortingController::class, 'approve'])->name('sorting.approve')->middleware('permission:approve-sorting');
});

// Inbound Module
Route::prefix('inbound')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [InboundController::class, 'index'])->name('inbound.index')->middleware('permission:view-inbound');
    Route::get('/create', [InboundController::class, 'create'])->name('inbound.create')->middleware('permission:create-inbound');
    Route::post('/', [InboundController::class, 'store'])->name('inbound.store')->middleware('permission:create-inbound');
    Route::get('/{id}/edit', [InboundController::class, 'edit'])->name('inbound.edit')->middleware('permission:edit-inbound');
    Route::put('/{id}', [InboundController::class, 'update'])->name('inbound.update')->middleware('permission:edit-inbound');
    Route::delete('/{id}', [InboundController::class, 'destroy'])->name('inbound.destroy')->middleware('permission:delete-inbound');
    Route::post('/{id}/approve', [InboundController::class, 'approve'])->name('inbound.approve')->middleware('permission:approve-inbound');
});

// Store Module
Route::prefix('store')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [StoreController::class, 'index'])->name('store.index')->middleware('permission:view-store');
    Route::get('/create', [StoreController::class, 'create'])->name('store.create')->middleware('permission:create-store');
    Route::post('/', [StoreController::class, 'store'])->name('store.store')->middleware('permission:create-store');
    Route::get('/{id}/edit', [StoreController::class, 'edit'])->name('store.edit')->middleware('permission:edit-store');
    Route::put('/{id}', [StoreController::class, 'update'])->name('store.update')->middleware('permission:edit-store');
    Route::delete('/{id}', [StoreController::class, 'destroy'])->name('store.destroy')->middleware('permission:delete-store');
    Route::post('/{id}/approve', [StoreController::class, 'approve'])->name('store.approve')->middleware('permission:approve-store');
});

// VNS Module
Route::prefix('vns')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [VnsController::class, 'index'])->name('vns.index')->middleware('permission:view-vns');
    Route::get('/create', [VnsController::class, 'create'])->name('vns.create')->middleware('permission:create-vns');
    Route::post('/', [VnsController::class, 'store'])->name('vns.store')->middleware('permission:create-vns');
    Route::get('/{id}/edit', [VnsController::class, 'edit'])->name('vns.edit')->middleware('permission:edit-vns');
    Route::put('/{id}', [VnsController::class, 'update'])->name('vns.update')->middleware('permission:edit-vns');
    Route::delete('/{id}', [VnsController::class, 'destroy'])->name('vns.destroy')->middleware('permission:delete-vns');
    Route::post('/{id}/approve', [VnsController::class, 'approve'])->name('vns.approve')->middleware('permission:approve-vns');
});

// Tables Module
Route::prefix('tables')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TablesController::class, 'index'])->name('tables.index')->middleware('permission:view-tables');
    Route::get('/create', [TablesController::class, 'create'])->name('tables.create')->middleware('permission:create-tables');
    Route::post('/', [TablesController::class, 'store'])->name('tables.store')->middleware('permission:create-tables');
    Route::get('/{id}/edit', [TablesController::class, 'edit'])->name('tables.edit')->middleware('permission:edit-tables');
    Route::put('/{id}', [TablesController::class, 'update'])->name('tables.update')->middleware('permission:edit-tables');
    Route::delete('/{id}', [TablesController::class, 'destroy'])->name('tables.destroy')->middleware('permission:delete-tables');
    Route::post('/{id}/approve', [TablesController::class, 'approve'])->name('tables.approve')->middleware('permission:approve-tables');
});

// Employee Affairs Module
Route::prefix('employee-affairs')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [EmployeeAffairsController::class, 'index'])->name('employee-affairs.index')->middleware('permission:view-employee-affairs');
    Route::get('/create', [EmployeeAffairsController::class, 'create'])->name('employee-affairs.create')->middleware('permission:create-employee-affairs');
    Route::post('/', [EmployeeAffairsController::class, 'store'])->name('employee-affairs.store')->middleware('permission:create-employee-affairs');
    Route::get('/{id}/edit', [EmployeeAffairsController::class, 'edit'])->name('employee-affairs.edit')->middleware('permission:edit-employee-affairs');
    Route::put('/{id}', [EmployeeAffairsController::class, 'update'])->name('employee-affairs.update')->middleware('permission:edit-employee-affairs');
    Route::delete('/{id}', [EmployeeAffairsController::class, 'destroy'])->name('employee-affairs.destroy')->middleware('permission:delete-employee-affairs');
    Route::post('/{id}/approve', [EmployeeAffairsController::class, 'approve'])->name('employee-affairs.approve')->middleware('permission:approve-employee-affairs');
});
// Returned Items Module
Route::prefix('returned-items')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ReturnedItemsController::class, 'index'])
        ->name('returned-items.index')
        ->middleware('permission:view-returned-items');
    
        Route::get('/create', [ReturnedItemsController::class, 'create'])
        ->name('returned-items.create')
        ->middleware('permission:create-returned-items');
    
    Route::post('/', [ReturnedItemsController::class, 'store'])
        ->name('returned-items.store')
        ->middleware('permission:create-returned-items');
    
    Route::get('/{id}/edit', [ReturnedItemsController::class, 'edit'])
        ->name('returned-items.edit')
        ->middleware('permission:edit-returned-items');
    
    Route::put('/{id}', [ReturnedItemsController::class, 'update'])
        ->name('returned-items.update')
        ->middleware('permission:edit-returned-items');
    
    Route::delete('/{id}', [ReturnedItemsController::class, 'destroy'])
        ->name('returned-items.destroy')
        ->middleware('permission:delete-returned-items');
    
    Route::post('/{id}/approve', [ReturnedItemsController::class, 'approve'])
        ->name('returned-items.approve')
        ->middleware('permission:approve-returned-items');
});

// Management Statistics Module
Route::prefix('management-statistics')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ManagementStatisticsController::class, 'index'])
        ->name('management-statistics.index')
        ->middleware('permission:view-management-statistics');

    Route::get('/create', [ManagementStatisticsController::class, 'create'])
        ->name('management-statistics.create')
        ->middleware('permission:create-management-statistics');

    Route::post('/', [ManagementStatisticsController::class, 'store'])
        ->name('management-statistics.store')
        ->middleware('permission:create-management-statistics');

    Route::get('/{id}/edit', [ManagementStatisticsController::class, 'edit'])
        ->name('management-statistics.edit')
        ->middleware('permission:edit-management-statistics');

    Route::put('/{id}', [ManagementStatisticsController::class, 'update'])
        ->name('management-statistics.update')
        ->middleware('permission:edit-management-statistics');

    Route::delete('/{id}', [ManagementStatisticsController::class, 'destroy'])
        ->name('management-statistics.destroy')
        ->middleware('permission:delete-management-statistics');

    Route::post('/{id}/approve', [ManagementStatisticsController::class, 'approve'])
        ->name('management-statistics.approve')
        ->middleware('permission:approve-management-statistics');
});


// Users Module 
    Route::prefix('users')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [UserController::class, 'index'])
            ->name('users.index')
            ->middleware('permission:view-users');
        
        Route::middleware('permission:create-users')->group(function () {
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/', [UserController::class, 'store'])->name('users.store');
        });

        Route::middleware('permission:edit-users')->group(function () {
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        });

        Route::middleware('permission:delete-users')->group(function () {
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::patch('/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
        });

        Route::post('/{id}/assign-role', [UserController::class, 'assignRole'])
            ->name('users.assign-role')
            ->middleware('permission:assign-roles');
    });


