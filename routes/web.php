<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('screens\login_screen', [
        "title" => "Project DD | Login",
    ]);
});

Route::get('/register', function () {
    return view('screens\register_screen', [
        "title" => "Project DD | Register",
    ]);
});


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
