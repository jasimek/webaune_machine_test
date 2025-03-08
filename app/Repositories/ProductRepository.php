<?php

namespace App\Repositories;

use App\Models\Media;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductRepository
{


    public function store($data)
    {
        $this->validateData($data);
        $product = Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock_quantity' => $data['stock_quantity']
        ]);

        return $product;
    }


    public function update($data, $product)
    {
        $this->validateData($data);
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->stock_quantity = $data['stock_quantity'];
        $product->save();
    }


    public function destroy($product)
    {
        $product->delete();
        return true;
    }


    public function getAllProducts()
    {
        return Product::all();
    }

    public function validateData($data, $for_update = false)
    {
        validator(
            $data,
            [
                'name'            => 'required',
                'description'     => 'required',
                'price'           => 'required|numeric|min:0',
                'stock_quantity'  => 'required|integer|min:0',
            ],
        )->validate();
    }
}
