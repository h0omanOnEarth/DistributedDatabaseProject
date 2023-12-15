<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function productsPage()
    {
        $user = Auth::user();
        return view('screens.admin.manage_product', ["user" => $user]);
    }
}
