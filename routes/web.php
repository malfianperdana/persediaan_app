<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RequestDetailController;
use App\Http\Controllers\StockLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Request
    Route::prefix('permintaan')->name('permintaan.')->group(function() {
        Route::get('/', [RequestController::class, 'index'])->name('index');
        Route::get('create', [RequestController::class, 'create'])->name('create');
        Route::post('store', [RequestController::class, 'store'])->name('store');
        Route::get('edit/{id}', [RequestController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [RequestController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [RequestController::class, 'destroy'])->name('destroy');
        Route::get('send/{id}', [RequestController::class, 'sendRequest'])->name('sendRequest');
        Route::get('approve/{id}', [RequestController::class, 'approve'])->name('approve');
        Route::get('reject/{id}', [RequestController::class, 'reject'])->name('reject');
    });
    
    // Request Detail
    Route::get('permintaan/{request}/detail', [RequestDetailController::class, 'index'])->name('permintaan.detail.index');
    Route::get('permintaan/{request}/detail/create', [RequestDetailController::class, 'create'])->name('permintaan.detail.create');
    Route::post('permintaan/{request}/detail', [RequestDetailController::class, 'store'])->name('permintaan.detail.store');
    Route::get('permintaan/{request}/detail/{detail}/edit', [RequestDetailController::class, 'edit'])->name('permintaan.detail.edit');
    Route::put('permintaan/{request}/detail/{detail}', [RequestDetailController::class, 'update'])->name('permintaan.detail.update');
    Route::delete('permintaan/{request}/detail/{detail}', [RequestDetailController::class, 'destroy'])->name('permintaan.detail.destroy');

    // Stock Logs
    Route::prefix('stock-logs')->name('stock_logs.')->middleware('auth')->group(function () {
        Route::get('/', [StockLogController::class, 'index'])->name('index');
        Route::get('create', [StockLogController::class, 'create'])->name('create');
        Route::post('store', [StockLogController::class, 'store'])->name('store');
        Route::get('edit/{id}', [StockLogController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [StockLogController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [StockLogController::class, 'destroy'])->name('destroy');
    });

    // Item
    Route::prefix('item')->group(function () {
        Route::get('/', [ItemController::class, 'index'])->name('jenis_barang.index');
        Route::get('create', [ItemController::class, 'create'])->name('jenis_barang.create');
        Route::post('store', [ItemController::class, 'store'])->name('jenis_barang.store');
        Route::get('edit/{id}', [ItemController::class, 'edit'])->name('jenis_barang.edit');
        Route::put('update/{id}', [ItemController::class, 'update'])->name('jenis_barang.update');
        Route::delete('destroy/{id}', [ItemController::class, 'destroy'])->name('jenis_barang.destroy');
    });

});

require __DIR__.'/auth.php';
