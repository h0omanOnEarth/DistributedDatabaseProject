<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('screens\login_screen', [
        "title" => "Project DD | Login",
        "active" => "active"
    ]);
});
