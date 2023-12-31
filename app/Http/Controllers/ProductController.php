<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductLog;
use App\Models\ProductViewB;
use App\Models\ProductViewC;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function gotoproducts()
    {
        $user = Auth::user();
        $items = Product::get();
        $itemsB = ProductViewB::all();
        $itemsC = ProductViewC::all();

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
        $isPass = false;
        $itemsB = [];
        try {

            try {
                $itemsB = DB::connection('oracle_b')
                    ->table('products')
                    ->where('nama', '=', $productName)
                    ->get();
                // dd($itemsB);
                $isPass = true;
            } catch (\Exception $e) {
                $isPass = false;
            }
            // dd($isPass);
            if ($isPass && !empty($itemsB) && count($itemsB) > 0) {
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
                    DB::statement("BEGIN dbms_mview.refresh('PRODUCTS_VIEW_B', 'f'); END;");

                    DB::table('products')
                        ->where('nama', $productName)
                        ->increment('stok', $amount);
                    DB::raw('commit;');
                } else {
                    //cek C
                    $isPass = false;
                    $itemsC = [];
                    try {
                        $itemsC = DB::connection('oracle_c')
                            ->table('products')
                            ->where('nama', '=', $productName)
                            ->get();
                        $isPass = true;
                    } catch (\Exception $e) {
                        $itemsC = [];
                        $isPass = false;
                    }
                    if ($isPass && !empty($itemsC) && count($itemsC) > 0) {
                        $productC = $itemsC[0];
                        $stockAvailableB = $stockAvailable;
                        $stockAvailable += $productC->stok;
                        if ($stockAvailable >= $amount) {
                            //ambil dari C & branch C
                            $newStockB = 0;
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
                            DB::statement("BEGIN dbms_mview.refresh('PRODUCTS_VIEW_B', 'f'); END;");
                            DB::statement("BEGIN dbms_mview.refresh('PRODUCTS_VIEW_C', 'f'); END;");

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
                $isPass = false;
                $itemsC = [];
                try {
                    $itemsC = DB::connection('oracle_c')
                        ->table('products')
                        ->where('nama', '=', $productName)
                        ->get();
                    $isPass = true;
                } catch (\Exception $e) {
                    $itemsC = [];
                    $isPass = false;
                }
                if ($isPass && !empty($itemsC) && count($itemsC) > 0) {
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
                        DB::statement("BEGIN dbms_mview.refresh('PRODUCTS_VIEW_C', 'f'); END;");
                        DB::raw('commit;');
                    } else {
                        return redirect('/seller/products')->with('failed', 'Stok cabang tidak mencukupi');
                    }
                } else {
                    return redirect('/seller/products')->with('failed', 'Stok cabang tidak tersedia');
                }
            }
            return redirect('/seller/products')->with('success', 'Berhasil ambil stok dari cabang lain');
        } catch (\Throwable $th) {
            return redirect('/seller/products')->with('failed', 'Stok cabang tidak tersedia');
        }
    }

    public function addProduct(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:1',
            'stok' => 'required|numeric|min:1',
        ]);
        $product = Product::create([
            'nama' => $data['nama'],
            'harga' => $data['harga'],
            'stok' => $data['stok'],
        ]);

        $logData = json_encode($product->toArray());
        // Catat log penambahan produk
        ProductLog::create([
            'product_id' => $product->id,
            'action' => 'created',
            'data' =>  $logData,
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
        $logData = json_encode($product->toArray());
        // Catat log pembaruan produk
        ProductLog::create([
            'product_id' => $product->id,
            'action' => 'updated',
            'data' => $logData
        ]);
        DB::raw('commit;');

        return redirect('/seller/products/update/' . $id)->with('success', 'Product updated successfully');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        // Catat log penghapusan produk
        $logData = json_encode($product->toArray());
        ProductLog::create([
            'product_id' => $product->id,
            'action' => 'deleted',
            'data' => $logData
        ]);
        DB::raw('commit;');

        return redirect('/seller/products')->with('success', 'Product deleted successfully');
    }

    public function sync()
    {
        try {
            // Ambil data dari koneksi A
            $productsA = DB::connection('oracle')->table('products')->get();

            // Loop melalui setiap produk di koneksi A
            foreach ($productsA as $productA) {
                // Cek apakah produk dengan nama yang sama sudah ada di koneksi B
                $productB = DB::connection('oracle_b')->table('products')->where('nama', $productA->nama)->first();

                // Jika tidak ada, tambahkan produk ke koneksi B dengan stok 0
                if (!$productB) {
                    DB::connection('oracle_b')->table('products')->insert([
                        'id' => $productA->id,
                        'nama' => $productA->nama,
                        'harga' => $productA->harga,
                        'stok' => 0, // Stok diatur menjadi 0
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    DB::connection('oracle_b')->commit();
                }

                // Cek apakah produk dengan nama yang sama sudah ada di koneksi C
                $productC = DB::connection('oracle_c')->table('products')->where('nama', $productA->nama)->first();

                // Jika tidak ada, tambahkan produk ke koneksi C dengan stok 0
                if (!$productC) {
                    DB::connection('oracle_c')->table('products')->insert([
                        'id' => $productA->id,
                        'nama' => $productA->nama,
                        'harga' => $productA->harga,
                        'stok' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    DB::connection('oracle_c')->commit();
                }
            }

            // Lakukan hal yang sama untuk koneksi B
            $productsB = DB::connection('oracle_b')->table('products')->get();
            foreach ($productsB as $productB) {
                // Cek apakah produk dengan nama yang sama sudah ada di koneksi A
                $productA = DB::connection('oracle')->table('products')->where('nama', $productB->nama)->first();

                // Jika tidak ada, tambahkan produk ke koneksi A dengan stok 0
                if (!$productA) {
                    DB::connection('oracle')->table('products')->insert([
                        'id' => $productB->id,
                        'nama' => $productB->nama,
                        'harga' => $productB->harga,
                        'stok' => 0, // Stok diatur menjadi 0
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    DB::connection('oracle')->commit();
                }

                // Cek apakah produk dengan nama yang sama sudah ada di koneksi C
                $productC = DB::connection('oracle_c')->table('products')->where('nama', $productB->nama)->first();

                // Jika tidak ada, tambahkan produk ke koneksi C dengan stok 0
                if (!$productC) {
                    DB::connection('oracle_c')->table('products')->insert([
                        'id' => $productB->id,
                        'nama' => $productB->nama,
                        'harga' => $productB->harga,
                        'stok' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    DB::connection('oracle_c')->commit();
                }
            }

            // Lakukan hal yang sama untuk koneksi C
            $productsC = DB::connection('oracle_c')->table('products')->get();
            foreach ($productsC as $productC) {
                // Cek apakah produk dengan nama yang sama sudah ada di koneksi A
                $productA = DB::connection('oracle')->table('products')->where('nama', $productC->nama)->first();

                // Jika tidak ada, tambahkan produk ke koneksi A dengan stok 0
                if (!$productA) {
                    DB::connection('oracle')->table('products')->insert([
                        'id' => $productC->id,
                        'nama' => $productC->nama,
                        'harga' => $productC->harga,
                        'stok' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    DB::connection('oracle')->commit();
                }

                // Cek apakah produk dengan nama yang sama sudah ada di koneksi B
                $productB = DB::connection('oracle_b')->table('products')->where('nama', $productC->nama)->first();

                // Jika tidak ada, tambahkan produk ke koneksi B dengan stok 0
                if (!$productB) {
                    DB::connection('oracle_b')->table('products')->insert([
                        'id' => $productC->id,
                        'nama' => $productC->nama,
                        'harga' => $productC->harga,
                        'stok' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    DB::connection('oracle_b')->commit();
                }
            }

            $user = Auth::user();
            $items = Product::get();
            $itemsB = ProductViewB::all();
            $itemsC = ProductViewC::all();

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


            DB::statement("BEGIN dbms_mview.refresh('PRODUCTS_VIEW_B', 'f'); END;");
            DB::statement("BEGIN dbms_mview.refresh('PRODUCTS_VIEW_C', 'f'); END;");
            DB::raw('commit;');

            return response()->json(['message' => 'Manual sync completed', "user" => $user, "products" => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error during sync: ' . $e->getMessage()], 500);
        }
    }
}
