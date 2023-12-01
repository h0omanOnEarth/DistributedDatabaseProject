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
        "title" => "Project DD | Manage User",
    ]);
});
