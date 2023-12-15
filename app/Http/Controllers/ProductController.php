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
            if (isset($products[$item->nama])) {
                $products[$item->nama]['stok'] += $item->stok;
            } else {
                $products[$item->nama] = [];
                $products[$item->nama]['id'] = $item->id;
                $products[$item->nama]['stok'] = $item->stok;
                $products[$item->nama]['stokB'] = 0;
                $products[$item->nama]['stokC'] = 0;
                $products[$item->nama]['harga'] = $item->harga;
            }
        }
        foreach ($itemsB as $item) {
            if (isset($products[$item->nama])) {
                $products[$item->nama]['stokB'] += $item->stok;
            } else {
                //DO NOTHING
            }
        }

        foreach ($itemsC as $item) {
            if (isset($products[$item->nama])) {
                $products[$item->nama]['stokC'] += $item->stok;
            } else {
                //DO NOTHING
            }
        }
        return view('screens.seller.master_products', ["user" => $user, "products" => $products]);
    }

    public function updateStock(Request $request)
    {
        $id = $request->id; //id produk
        $product = Product::find($id);
        $productName = $product->nama;
        $amount = intval($request->stock_quantity);
        $itemsB = DB::connection('oracle_b')->table('products')->where('nama', '=', $productName)
            ->get();
        if (!empty($itemsB) && count($itemsB) > 0) {
            $productB = $itemsB[0];
            $stockAvailable = $productB->stok;
            if ($stockAvailable >= $amount) {
                //cuma ambil dari branch B
                $newStockB = $stockAvailable - $amount;
                DB::connection('oracle_b')
                    ->table('products')
                    ->where('nama', $productName)
                    ->update(['stok' => $newStockB]);
                DB::connection('oracle_b')->raw('commit;');

                DB::table('products')
                    ->where('nama', $productName)
                    ->increment('stok', $amount);
                DB::raw('commit;');
            } else {
                //cek C
                $itemsC = DB::connection('oracle_c')->table('products')->where('nama', '=', $productName)
                    ->get();
                if (!empty($itemsC) && count($itemsC) > 0) {
                    $productC = $itemsC[0];
                    $stockAvailableB = $stockAvailable;
                    $stockAvailable += $productC->stok;
                    if($stockAvailable >= $amount){
                        //ambil dari C & branch C
                        //kurangi yang B dulu
                        $newStockB = $amount - $stockAvailableB;

                        DB::connection('oracle_b')
                            ->table('products')
                            ->where('nama', $productName)
                            ->update(['stok' => $newStockB]);
                        DB::connection('oracle_b')->raw('commit;');

                        DB::connection('oracle_b')->raw('commit;');

                        //kurangi C
                        $newStockC = $productC->stok - ($amount - $stockAvailableB);
                        DB::connection('oracle_c')
                            ->table('products')
                            ->where('nama', $productName)
                            ->update(['stok' => $newStockC]);
                        DB::connection('oracle_c')->raw('commit;');

                        DB::table('products')
                            ->where('nama', $productName)
                            ->increment('stok', $amount);
                        DB::raw('commit;');
                    } else {
                        return redirect('/seller/products')->with('failed', 'Stok cabang tidak mencukupi');
                    }
                } else {
                    //error stok
                    return redirect('/seller/products')->with('failed', 'Stok cabang tidak mencukupi');
                }
            }
        } else {
            //check branch C
            $itemsC = DB::connection('oracle_c')->table('products')->where('nama', '=', $productName)
                ->get();
            if (!empty($itemsC) && count($itemsC) > 0) {
                $productC = $itemsC[0];
                $stockAvailable = $productC->stok;
                if ($stockAvailable >= $amount) {
                    //cuma ambil dari branch C
                    $newStockC = $stockAvailable - $amount;
                    DB::connection('oracle_c')
                        ->table('products')
                        ->where('nama', $productName)
                        ->update(['stok' => $newStockC]);
                    DB::connection('oracle_c')->raw('commit;');

                    DB::table('products')
                        ->where('nama', $productName)
                        ->increment('stok', $amount);
                    DB::raw('commit;');
                } else {
                    return redirect('/seller/products')->with('failed', 'Stok cabang tidak mencukupi');
                }
            } else {
                return redirect('/seller/products')->with('failed', 'Stok cabang tidak tersedia');
            }
        }
        return redirect('/seller/products')->with('success', 'Berhasil ambil stok dari cabang lain');
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
        DB::raw('commit;');
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
        DB::raw('commit;');

        return redirect('/seller/products/update/' . $id)->with('success', 'Product updated successfully');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        DB::raw('commit;');

        return redirect('/seller/products')->with('success', 'Product deleted successfully');
    }
}
