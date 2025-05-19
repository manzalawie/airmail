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
Route::prefix('hscode')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [HscodeController::class, 'index'])->name('hscode.index')->middleware('permission:view-hscode');
    Route::get('/create', [HscodeController::class, 'create'])->name('hscode.create')->middleware('permission:create-hscode');
    Route::post('/', [HscodeController::class, 'store'])->name('hscode.store')->middleware('permission:create-hscode');
    Route::get('/{id}/edit', [HscodeController::class, 'edit'])->name('hscode.edit')->middleware('permission:edit-hscode');
    Route::put('/{id}', [HscodeController::class, 'update'])->name('hscode.update')->middleware('permission:edit-hscode');
    Route::delete('/{id}', [HscodeController::class, 'destroy'])->name('hscode.destroy')->middleware('permission:delete-hscode');
    Route::post('/{id}/approve', [HscodeController::class, 'approve'])->name('hscode.approve')->middleware('permission:approve-hscode');
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
Route::prefix('employeeaffairs')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [EmployeeAffairsController::class, 'index'])->name('employeeaffairs.index')->middleware('permission:view-employeeaffairs');
    Route::get('/create', [EmployeeAffairsController::class, 'create'])->name('employeeaffairs.create')->middleware('permission:create-employeeaffairs');
    Route::post('/', [EmployeeAffairsController::class, 'store'])->name('employeeaffairs.store')->middleware('permission:create-employeeaffairs');
    Route::get('/{id}/edit', [EmployeeAffairsController::class, 'edit'])->name('employeeaffairs.edit')->middleware('permission:edit-employeeaffairs');
    Route::put('/{id}', [EmployeeAffairsController::class, 'update'])->name('employeeaffairs.update')->middleware('permission:edit-employeeaffairs');
    Route::delete('/{id}', [EmployeeAffairsController::class, 'destroy'])->name('employeeaffairs.destroy')->middleware('permission:delete-employeeaffairs');
    Route::post('/{id}/approve', [EmployeeAffairsController::class, 'approve'])->name('employeeaffairs.approve')->middleware('permission:approve-employeeaffairs');
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


