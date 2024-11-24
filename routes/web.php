<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('carts', CartController::class);
Route::post('carts', [CartController::class, 'store'])->name('carts.store');
Route::post('carts/checkout', [CartController::class, 'checkout'])->name('carts.checkout');
