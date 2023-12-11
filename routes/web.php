<?php

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Seller\HomeController as SellerHomeController;
use App\Http\Controllers\Customer\HomeController as CustomerHomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'loginPage']);
Route::get('/register', [AuthController::class, 'registerPage']);
Route::post('/doLogin', [AuthController::class, 'doLogin']);
Route::post('/doRegister', [AuthController::class, 'doRegister']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::prefix('admin')->group(function () {
    Route::get('/home', [AdminHomeController::class, 'homePage']);
});

Route::prefix('customer')->group(function () {
    Route::get('/home', [CustomerHomeController::class, 'homePage']);
});

Route::prefix('seller')->group(function () {
    Route::get('/home', [SellerHomeController::class, 'homePage']);

    Route::get('/products', [ProductController::class, 'gotoproducts']);
    Route::post('/products', [
        ProductController::class,
        'addProduct'
    ]);
});


Route::get('/admin/products', function () {
    return view('screens\admin\manage_products', [
        "title" => "Project DD | Manage Products",
    ]);
});

Route::get('/admin/transactions', function () {
    return view('screens\admin\manage_transactions', [
        "title" => "Project DD | Manage Transaksi",
    ]);
});
