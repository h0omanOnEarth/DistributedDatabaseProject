<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function homePage(){
        $user = Auth::user();
        $products = DB::connection('oracle_c')->select("SELECT * FROM products");

        dd($products);
        return view('screens.seller.home',["user"=>$user]);
    }
}
