<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function loginPage(){
        return view('screens.login_screen');
    }

    function registerPage(){
        return view('screens.register_screen');
    }

    public function doLogin(Request $request){

    }

    public function doRegister(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:customer,seller',
        ]);
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
        ]);

        return back()->with('success', 'Berhasil register!');
    }
}
