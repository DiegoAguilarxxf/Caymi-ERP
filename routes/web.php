<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::view('/', 'welcome')->name('home');

// Rutas Admin
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
   Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::get('orders', [OrderController::class, 'adminIndex'])->name('orders.index');
    Route::patch('orders/{order}', [OrderController::class, 'updateStatus'])->name('orders.update');
    Route::get('chat', [\App\Http\Controllers\ChatbotController::class, 'adminIndex'])->name('chat');
    Route::post('chat', [\App\Http\Controllers\ChatbotController::class, 'adminAsk'])->name('chat.ask');
});

// Rutas Cliente
Route::middleware(['auth', 'verified', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::view('dashboard', 'client.dashboard')->name('dashboard');
    Route::get('catalog', [ProductController::class, 'catalog'])->name('catalog');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('chat', [\App\Http\Controllers\ChatbotController::class, 'index'])->name('chat');
    Route::post('chat', [\App\Http\Controllers\ChatbotController::class, 'ask'])->name('chat.ask');
});

require __DIR__.'/settings.php';