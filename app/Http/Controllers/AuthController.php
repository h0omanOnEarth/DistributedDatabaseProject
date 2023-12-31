<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function loginPage()
    {
        return view('screens.login_screen');
    }

    function registerPage()
    {
        return view('screens.register_screen');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $status = $user->status;
            if($status == 1){
                if ($user->role == 'customer') {
                    return redirect('/customer/home');
                } elseif ($user->role == 'seller') {
                    return redirect('/seller/products');
                } elseif ($user->role == 'admin') {
                    return redirect('/admin/home');
                }
            }
            else{
                return back()->with('error', 'Kamu di ban');
            }
        } else {
            return back()->with('error', 'Gagal login');
        }
    }

    public function doRegister(Request $request)
    {
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
            'status' => 1
        ]);

        return back()->with('success', 'Berhasil register!');
    }
    public function Logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Berhasil logout');
    }
}
