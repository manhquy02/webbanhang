<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;

use App\Http\Controllers\AuthController;
 

 Route::resource('/test',TestController::class);
Route::post('/test',[TestController::class,'register']);
// Route::middleware('api')->get('/test', function (Request $request) {
//     return response()->json(['message' => 'API working']);
// });

// Route::get('/products',[ProductController::class,'index']);
// Route::post('/products',[ProductController::class,'store']);
// Route::put('/products/{id}',[ProductController::class,'update']);
// Route::delete('/products/{id}',[ProductController::class,'destroy']);
// Route::apiResource('products',ProductController::class);
// Route::apiResource('users',UserController::class);
// Route::post('/register',[AuthController::class,'register']);
// Route::post('/login',[AuthController::class,'login']);
// Route::middleware(['jwt.auth'])->group(function(){
//     Route::apiResource('orders',OrderController::class);

// });

