<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function homePage()
    {
        $user = Auth::user();
        $items = Product::all();
        return view('screens.customer.home', ['user' => $user, 'products' => $items]);
    }
}
