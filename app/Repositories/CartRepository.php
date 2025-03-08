<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Media;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CartRepository
{
    public function addToCart($data)
    {
        $customer = Auth::guard('customer')->user();

        $existing_cart_item  = Cart::where('customer_id', $customer->id)->where('product_id', $data['id'])->first();

        if ($existing_cart_item) {
            $existing_cart_item->quantity += 1;
            $existing_cart_item->price = $existing_cart_item->quantity * $existing_cart_item->product->price;
            $existing_cart_item->save();
        } else {
            $cart = Cart::create([
                'customer_id' => $customer->id,
                'product_id' => $data['id'],
                'quantity' => 1,
                'price' => $data['price'],
            ]);
        }



        return true;
    }

    public function removeFromCart($cart)
    {
        $cart->delete();
        return $cart;
    }

    public function increaseOrDecreaseQuantity($data, $cart)
    {
        if (!$cart) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }

        if (!$data['is_decrement']) {
            if ($cart->quantity < $cart->product->stock_quantity) {
                $cart->quantity += 1;
            } else {
                throw new Exception('Out Of Stock', 1001);
            }
        } elseif ($data['is_decrement']) {
            if ($cart->quantity > 1) {
                $cart->quantity -= 1;
            }else{
                throw new Exception('Minimum One Quantity Required', 1001);
            }
        }

        $cart->price = $cart->quantity * $cart->product->price;
        $cart->save();

        return response()->json($cart);;
    }
}
