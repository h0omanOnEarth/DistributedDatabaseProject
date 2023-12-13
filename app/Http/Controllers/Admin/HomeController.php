<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function homePage()
    {
        $user = Auth::user();
        $users = User::get();
        return view('screens.admin.manage_users', ["user" => $user, "items" => $users]);
    }
}
