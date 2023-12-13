<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

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
}
