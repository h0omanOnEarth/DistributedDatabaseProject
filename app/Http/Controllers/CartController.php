<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Dtrans;
use App\Models\Htrans;
use App\Models\Pengirimans;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        // Assuming you have a Cart model
        $user = Auth::user();
        $cartItems = Cart::where('users_id', $user->id)->get();
        $subtotal =  $this->calculateSubtotal($cartItems);
        $locations = Pengirimans::pluck('lokasi', 'id');

        return view('screens.customer.cart', ['user' => $user, 'cartItems' => $cartItems, 'subtotal' => $subtotal, 'locations' => $locations]);
    }

    private function calculateSubtotal($cartItems)
    {
        $subtotal = 0;

        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem->products_id);
            $subtotal += $product->harga * $cartItem->qty;
        }

        return $subtotal;
    }

    public function addToCart(Request $request, $productId)
    {
        $user = Auth::user();
        $quantity = $request->input('quantity', 1);

        // Check if the product is already in the cart for the user
        $existingCartItem = Cart::where('users_id', $user->id)
            ->where('products_id', $productId)
            ->first();

        if ($existingCartItem) {
            // If the product is already in the cart, update the quantity
            $existingCartItem->update(['qty' => $existingCartItem->qty + $quantity]);
            DB::raw('commit;');
        } else {
            // If not, add a new item to the cart
            Cart::create([
                'users_id' => $user->id,
                'products_id' => $productId,
                'qty' => $quantity,
            ]);
            DB::raw('commit;');
        }

        return redirect('customer/cart')->with('success', 'Product added to cart successfully!');
    }

    public function updateQty(Request $request)
    {
        $cartItemId = $request->input('cartItemId');
        $action = $request->input('action');
        $productId = $request->input('productId');

        // Lakukan proses update pada tabel 'cart'
        DB::beginTransaction();

        try {
            // Ambil data cartItem
            $cartItem = Cart::find($cartItemId);

            if (!$cartItem) {
                return response()->json(['error' => 'Cart item not found'], 404);
            }

            // Ambil data product
            $product = Product::find($productId);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            $newQty = $cartItem->qty;

            if ($action === 'increment') {
                // Lakukan penambahan quantity
                $newQty++;
            } elseif ($action === 'decrement' && $newQty > 1) {
                // Lakukan pengurangan quantity, pastikan tidak kurang dari 1
                $newQty--;
            }

            // Update quantity pada cart
            $cartItem->update(['qty' => $newQty]);

            // Update stok pada tabel 'products' jika diperlukan
            // Contoh: $product->update(['stok' => $product->stok - 1]);

            DB::commit();

            // Setelah berhasil diupdate, kembalikan response dengan data qty yang baru
            // Setelah selesai memperbarui quantity, perbarui juga subtotal
            $user = Auth::user();
            $cartItems = Cart::where('users_id', $user->id)->get();
            $subtotal = $this->calculateSubtotal($cartItems);

            return response()->json(['qty' => $newQty, 'subtotal' => $subtotal]);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();

            // Handle error, misalnya log atau kirim response error
            return response()->json(['error' => 'Failed to update quantity'], 500);
        }
    }

    public function deleteItem(Request $request)
    {
        $cartItemId = $request->input('cartItemId');

        try {
            // Temukan item keranjang berdasarkan ID
            $cartItem = Cart::find($cartItemId);

            // Hapus item dari keranjang
            $cartItem->delete();
            DB::raw('commit;');

            // Hitung ulang subtotal dan kirim respons
            $user = Auth::user();
            $cartItems = Cart::where('users_id', $user->id)->get();
            $subtotal = $this->calculateSubtotal($cartItems);

            return response()->json(['subtotal' => $subtotal]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['error' => 'Failed to delete item from cart.'], 500);
        }
    }

    public function checkout(Request $request)
    {
        // Mendapatkan data dari cart
        $user = Auth::user();
        $cartItems = Cart::where('users_id', $user->id)->get();

        // Memeriksa ketersediaan stok
        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem->products_id);
            if ($product->stok - $cartItem->qty < 0) {
                // Jika stok tidak mencukupi, kembalikan response error
                return response()->json(['error' => 'Not enough stock for product ' . $product->nama], 400);
            }
        }

        // Memproses checkout
        DB::beginTransaction();

        try {
            // Membuat kode transaksi berdasarkan format tanggal dan urutan
            $transCode = date('Ymd') . sprintf('%04d', Htrans::count() + 1);

            // Menghitung subtotal
            $subtotal = $this->calculateSubtotal($cartItems);

            // Mengambil data lokasi dari request
            $locationId = $request->input('location');

            // Fetching data from 'pengirimans'
            $pengiriman = Pengirimans::find($locationId);
            $ctrEstimasi = $pengiriman->estimasi;

            // Create record in 'Htrans'
            Htrans::create([
                'kode' => $transCode,
                'subtotal' => $subtotal,
                'status' => 'pending', // You can change the status as needed
                'pengirimans_id' => $locationId,
                'users_id' => $user->id,
                'ctr_estimasi' => $ctrEstimasi,
            ]);

            // Menyimpan ke tabel dtrans
            foreach ($cartItems as $cartItem) {
                Dtrans::create([
                    'htrans_kode' => $transCode,
                    'products_id' => $cartItem->products_id,
                    'qty' => $cartItem->qty,
                ]);

                // Mengurangi stok di tabel products
                $product = Product::find($cartItem->products_id);
                $product->update(['stok' => $product->stok - $cartItem->qty]);

                // Remove item from the cart only if it's successfully checked out
                Cart::where('id', $cartItem->id)->delete();
            }

            DB::commit();

            // Setelah berhasil checkout, kembalikan response sukses
            return response()->json(['success' => 'Checkout successful'], 200);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();

            // Handle error, misalnya log atau kirim response error
            return response()->json(['error' => 'Failed to checkout. ' . $e->getMessage()], 500);
        }
    }
}
