<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $product_repo;


    public function __construct(ProductRepository $product_repo)
    {
        $this->product_repo = $product_repo;
    }

    public function getAllProducts()
    {
        return response()->json([
            'products' => $this->product_repo->getAllProducts()
        ]);
    }
}
