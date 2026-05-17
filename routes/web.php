<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::view('/', 'welcome')->name('home');

// Rutas Admin
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');
    Route::resource('products', ProductController::class);
});

// Rutas Cliente
Route::middleware(['auth', 'verified', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::view('dashboard', 'client.dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';