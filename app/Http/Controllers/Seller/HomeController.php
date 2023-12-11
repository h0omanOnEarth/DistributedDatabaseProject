<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function homePage(){
        $user = Auth::user();
        return view('screens.seller.home',["user"=>$user]);
    }
}
