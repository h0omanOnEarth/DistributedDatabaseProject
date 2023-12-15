<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function gotoproducts()
    {
        $user = Auth::user();
        $items = Product::get();
        $itemsB = DB::connection('oracle_b')->select("SELECT * FROM products");
        $itemsC = DB::connection('oracle_c')->select("SELECT * FROM products");

        $products = [];
        foreach ($items as $item) {
            if(isset($products[$item->nama])){
                $products[$item->nama]['stok'] += $item->stok;
            }
            else{
                $products[$item->nama] = [];
                $products[$item->nama]['id'] = $item->id;
                $products[$item->nama]['stok'] = $item->stok;
                $products[$item->nama]['stokB'] = 0;
                $products[$item->nama]['stokC'] = 0;
                $products[$item->nama]['harga'] = $item->harga;

            }
        }
        foreach ($itemsB as $item) {
            if(isset($products[$item->nama])){
                $products[$item->nama]['stokB'] += $item->stok;
            }
            else{
                //DO NOTHING
            }
        }

        foreach ($itemsC as $item) {
            if(isset($products[$item->nama])){
                $products[$item->nama]['stokC'] += $item->stok;
            }
            else{
               //DO NOTHING
            }
        }
        return view('screens.seller.master_products', ["user" => $user,"products"=>$products]);
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
