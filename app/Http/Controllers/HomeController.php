<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    protected $product_repo;


    public function __construct(ProductRepository $product_repo)
    {
        $this->product_repo = $product_repo;
    }

    public function index()
    {
        return Inertia::render('Home/Index', [
            'products' => $this->product_repo->getAllProducts()
        ]);
    }
}
