<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});
// Boss only routes
Route::middleware(['auth', 'verified', 'boss'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
});

// Boss and worker routes
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Business routes
    Route::get('/business/create', [BusinessController::class, 'create'])->name('business.create');
    Route::post('/business/store', [BusinessController::class, 'store'])->name('business.store');

    // Worker routes
    Route::resource('workers', WorkerController::class);
    Route::get('workers/{worker}/toggle-status', [WorkerController::class, 'toggleStatus'])->name('workers.toggleStatus');

    // Product routes
    Route::resource('products', ProductController::class);

    // Sales routes
    Route::resource('sales', SaleController::class);
});

require __DIR__.'/auth.php';