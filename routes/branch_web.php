<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Auth::routes();

// Route::group(['prefix' => 'branch', 'as' => 'branch.'], function () {
//     Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'adminHome'])->name('admin-home');
//     Route::resource('product', \App\Http\Controllers\Admin\ProductController::class);
//     Route::resource('purchase', \App\Http\Controllers\Admin\PurchaseController::class);
//     Route::get('get-product/{sku}', \App\Http\Controllers\Admin\ProductInfoController::class)->name('get-product');
// });
