<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('customer')->user();
        $cartItems = Cart::where('customer_id', $user->id)
            ->with('product') // assumes a relationship defined in Cart model
            ->get();

        return response()->json($cartItems);
    }

    /**
     * Add an item to the cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'sometimes|integer|min:1',
        ]);

        $user = Auth::guard('customer')->user();
        $product = Product::find($request->product_id);
        $quantity = $request->input('quantity', 1);

        // Check if this product is already in the cart
        $cart = Cart::where('customer_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            // Update the quantity
            $cart->quantity += $quantity;
        } else {
            // Create a new cart entry
            $cart = new Cart();
            $cart->customer_id = $user->id;
            $cart->product_id = $product->id;
            $cart->quantity = $quantity;
        }

        // Calculate the price based on quantity and product price
        $cart->price = $cart->quantity * $product->price;
        $cart->save();

        return response()->json($cart, 201);
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $cart = Cart::where('customer_id', $user->id)->where('id', $id)->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $cart->delete();

        return response()->json(['message' => 'Cart item removed successfully']);
    }
}
