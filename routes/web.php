<?php

// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return ('welcome');
});

Route::resource('test', TestController::class);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('orders', OrderController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    
    Route::get('/products-export', [ProductController::class, 'export'])->name('products.export');
    Route::get('/users-export', [UserController::class, 'export'])->name('users.export');
    Route::get('/orders-export', [OrderController::class, 'export'])->name('orders.export');
});
