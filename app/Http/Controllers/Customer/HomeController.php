<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function homePage(){
        $user = Auth::user();
        return view('screens.customer.home',['user'=>$user]);
    }
}
