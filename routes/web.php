<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class,'loginPage']);

Route::get('/register', [AuthController::class,'registerPage']);
Route::post('/doLogin', [AuthController::class,'doLogin']);
Route::post('/doRegister', [AuthController::class,'doRegister']);


Route::get('/admin/users', function () {
    return view('screens\admin\manage_users', [
        "title" => "Project DD | Manage Users",
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
