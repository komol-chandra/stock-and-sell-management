<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('product', \App\Http\Controllers\Admin\ProductController::class);
        Route::resource('purchase', \App\Http\Controllers\Admin\PurchaseController::class);
    Route::get('get-product/{sku}', \App\Http\Controllers\Admin\ProductInfoController::class)->name('get-product');

    Route::get('top-sell-product', [ReportController::class,'topSellProduct'])->name('top-sell-product');
    Route::get('top-customer', [ReportController::class,'topCustomer'])->name('top-customer');
    Route::get('order-list', [ReportController::class,'orderList'])->name('order-list');
    Route::get('order-view/{id}', [ReportController::class,'orderView'])->name('order-view');

});

Route::group(['middleware' => ['auth', 'frontend.user'], 'prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/', function () {
        dd("user");
    })->name('dashboard');

});

Route::group(['middleware' => ['auth', 'branch'], 'prefix' => 'branch', 'as' => 'branch.'], function () {
    Route::get('/', [\App\Http\Controllers\Branch\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('product-stock-list', [\App\Http\Controllers\Branch\DashboardController::class, 'productStockList'])
        ->name('product-stock-list');

    Route::resource('sell-point', \App\Http\Controllers\Branch\SellPointController::class);
    Route::get('get-product-list', [\App\Http\Controllers\Branch\SellPointController::class, 'getProductList'])
        ->name('get-product-list');
    Route::get('order-list', [\App\Http\Controllers\Branch\SellPointController::class, 'orderList'])
        ->name('order-list');

    Route::resource('users', \App\Http\Controllers\UserController::class);
});
