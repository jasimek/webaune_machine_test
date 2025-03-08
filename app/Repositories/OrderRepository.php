<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Media;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrderRepository
{


    public function store($data)
    {


        // $this->validateData($data);

        $order  = Order::create([

            'customer_id' => $data['customer']['id'],
            'total_amount' => 0,
            'status' => 'pending',
        ]);

        $this->storeOrderItems($data, $order);

        return $order;
    }

    public function storeOrderItems($data, $order)
    {
        $total_amount = 0;


        foreach ($data['products'] as $product) {
            $product = Product::findOrFail($product['id']);

            if ($product->stock_quantity < 1) {
                throw new \Exception("Insufficient stock for product: {$product->name}");
            }

            $subtotal = $product->price * 1;
            $total_amount += $subtotal;


            // dd($product);


            $order->orderItems()->create([
                'product_id' => $product->id,
                'quantity' => 1,
                'subtotal' => $subtotal,
            ]);

            $product->decrement('stock_quantity', 1);
        }

        $order->total_amount = $total_amount;

        $order->save();

        return $order;
    }

    public function addToOrders($data)
    {
        $customer = Auth::guard('customer')->user();

        $order = Order::create([
            'customer_id' => $customer->id,
            'product_id' => $data['product_id'],
            'total_price' => $data['total']
        ]);

        return $order;
    }

    public function getAllOrders()
    {
        return Order::with('customer', 'orderItems.product')->get();
    }

    public function validateData($data)
    {

        // validator(
        //     $data,
        //     [
        //         'customer' => 'required|array',
        //         'customer.*.id' => 'required|exists:customers,id',
        //         'products' => 'required|array',
        //         'products.*.id' => 'required|exists:products,id',
        //         // 'products.*.quantity' => 'required|integer|min:1',
        //     ]
        // )->validate();
    }
}
