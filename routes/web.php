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
