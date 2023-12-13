<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
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

        return view('screens.customer.cart', ['user' => $user, 'cartItems' => $cartItems]);
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
        } else {
            // If not, add a new item to the cart
            Cart::create([
                'users_id' => $user->id,
                'products_id' => $productId,
                'qty' => $quantity,
            ]);
        }

        return redirect('customer/cart')->with('success', 'Product added to cart successfully!');
    }

    public function updateCart(Request $request, $cartItemId)
    {
        $newQuantity = $request->input('quantity');

        // Update the quantity for the specified cart item
        Cart::where('id', $cartItemId)->update(['qty' => $newQuantity]);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }


    public function removeFromCart($cartItemId)
    {
        // Delete the specified cart item
        Cart::destroy($cartItemId);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully!');
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
            return response()->json(['qty' => $newQty]);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();

            // Handle error, misalnya log atau kirim response error
            return response()->json(['error' => 'Failed to update quantity'], 500);
        }
    }
}
