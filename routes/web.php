<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinancialRecordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    // Level 1: Operations List
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('operations', [DashboardController::class, 'storeOperation'])->name('operations.store_main');
    
    // Level 2: Detailed Operation Ledger
    Route::get('operations/{operation}', [DashboardController::class, 'show'])->name('operations.show');
    
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    
    // Financial Records API (linked to operations)
    Route::post('operations/{operation}/records', [FinancialRecordController::class, 'store'])->name('records.store');
    Route::patch('records/{record}', [FinancialRecordController::class, 'update'])->name('records.update');
});
