<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function productsPage()
    {
        $user = Auth::user();
        $products = Product::get();
        return view('screens.admin.manage_products', ["user" => $user, "items" => $products]);
    }
}
