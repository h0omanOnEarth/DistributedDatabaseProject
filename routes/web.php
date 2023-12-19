<?php

use App\Http\Controllers\Admin\CronJobController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\LogsController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\HistoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Seller\HomeController as SellerHomeController;
use App\Http\Controllers\Customer\HomeController as CustomerHomeController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'loginPage']);
Route::get('/register', [AuthController::class, 'registerPage']);
Route::post('/doLogin', [AuthController::class, 'doLogin']);
Route::post('/doRegister', [AuthController::class, 'doRegister']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::prefix('admin')->group(function () {
    Route::get('/home', [AdminHomeController::class, 'homePage']);
    Route::get('/users', [UserController::class, 'usersPage']);
    Route::get('/users/block/{id}', [UserController::class, 'blockUser']);
    Route::get('/transactions', [TransactionController::class, 'transactionsPage']);
    Route::get('/logs', [LogsController::class, 'index']);
    Route::get('/cronjob_manual', [CronJobController::class, 'index']);
    Route::post('/cronjob_manual', [CronJobController::class, 'create'])->name('create.cronjob');
    Route::get('/products', [AdminProductController::class, 'productsPage']);
    Route::get('/products/sync', [ProductController::class, 'sync'])->name('products.sync');
});

Route::prefix('customer')->group(function () {
    Route::get('/home', [CustomerHomeController::class, 'homePage']);
    Route::get('/history', [HistoryController::class, 'gotohistory']);
    Route::get('/history/konfirmasiOrder/{kode}', [OrderController::class, 'konfirmasiOrder'])->name('konfirmasiOrder');
    Route::get('/history/bayarOrder/{kode}', [OrderController::class, 'bayarOrder'])->name('bayarOrder');
    Route::post('/add-to-cart/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/updateQty', [CartController::class, 'updateQty'])->name('cart.updateQty');
    Route::post('/cart/deleteItem', [CartController::class, 'deleteItem'])->name('cart.deleteItem');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

Route::prefix('seller')->group(function () {
    Route::get('/home', [SellerHomeController::class, 'homePage']);

    Route::get('/products', [ProductController::class, 'gotoproducts']);
    Route::post('/products', [
        ProductController::class,
        'addProduct'
    ]);
    Route::get('/products/update/{id}', [ProductController::class, 'gotoupdateproduct']);
    Route::put('/products/update/{id}', [ProductController::class, 'updateProduct']);
    Route::get('/products/delete/{id}', [ProductController::class, 'deleteProduct']);
    Route::post('/products/getStock', [ProductController::class, 'updateStock']);

    Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('pengiriman.index');
    Route::post('/pengiriman/store', [PengirimanController::class, 'store'])->name('pengiriman.store');
    Route::delete('/pengiriman/{id}', [PengirimanController::class, 'destroy'])->name('pengiriman.destroy');
    Route::put('/pengiriman/{id}/update', [PengirimanController::class, 'update'])->name('pengiriman.update');
    Route::get('/pengiriman/{id}', [PengirimanController::class, 'edit'])->name('pengiriman.edit');
    Route::get('/seller/products/sync', [ProductController::class, 'sync'])->name('products.sync');
});
