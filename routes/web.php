<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect('/login');
});

// Routes na kailangan ng login
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Staff can view (index, show)
    Route::resource('categories', CategoryController::class)->only(['index', 'show']);
    Route::resource('products', ProductController::class)->only(['index', 'show']);

    // Admin only (create, store, edit, update, destroy)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('categories', CategoryController::class)->except(['index', 'show']);
        Route::resource('products', ProductController::class)->except(['index', 'show']);
    });

    // Profile management (optional galing kay Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze auth routes (login, register, forgot password, etc.)
require __DIR__.'/auth.php';
