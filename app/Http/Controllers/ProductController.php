<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function gotoproducts()
    {
        $user = Auth::user();
        $items = Product::get();
        return view('screens.seller.master_products', ["user" => $user, "items" => $items]);
    }

    public function addProduct(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:1',
            'stok' => 'required|numeric|min:1',
        ]);
        Product::create([
            'nama' => $data['nama'],
            'harga' => $data['harga'],
            'stok' => $data['stok'],
        ]);

        return back()->with('success', 'Product added successfully!');
    }

    public function gotoupdateproduct($id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);
        return view('screens.seller.update_products', ["user" => $user, "product" => $product]);
    }


    public function updateProduct($id)
    {
        $product = Product::findOrFail($id);

        $validatedData = request()->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:1',
            'stok' => 'required|numeric|min:1',
        ]);

        $product->update($validatedData);

        return redirect('/seller/products/update/' . $id)->with('success', 'Product updated successfully');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect('/seller/products')->with('success', 'Product deleted successfully');
    }
}
