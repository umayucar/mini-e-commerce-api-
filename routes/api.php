<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// PRODUCT ROUTES
Route::get('/products', [ProductController::class, 'index']);

// CART ROUTES
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'store']);
Route::post('/cart/{cart_id}/items', [CartController::class, 'add']);
Route::get('/cart/{cart_id}/total', [CartController::class, 'total']);
