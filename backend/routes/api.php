<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\AuthController; // <-- Import AuthController
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;

// Rute Publik (tidak perlu login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// Rute Terproteksi (wajib login)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/sales', [SaleController::class, 'store']);
    
    // Rute CRUD produk yang butuh login kita pindahkan ke sini
    Route::apiResource('products', ProductController::class)->except(['index', 'show']);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('categories', CategoryController::class);
     Route::get('/dashboard', [DashboardController::class, 'summary']);
});
