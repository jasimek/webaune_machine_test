<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Throwable;

class ProductController extends Controller
{

    protected $product_repo;

    public function __construct(ProductRepository $product_repo)
    {
        $this->product_repo = $product_repo;
    }

    public function index()
    {

        // dd(Auth::guard('web')->user());

        return Inertia::render('Admin/Product/Index', [
            'products' => $this->product_repo->getAllProducts()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Product/Create');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Admin/Product/Edit', [
            'product' => $product
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $product = $this->product_repo->store($request->all());
        } catch (Throwable $th) {
            DB::rollBack();
            // return response()->json(['message' => 'Error'], 500);

            throw $th;

            // return back()->withErrors($th->getMessage());

            // return back();


        }
        DB::commit();
        // return response()->json(['message' => 'Success'], 200);
        // return back();

        return redirect()->route('products.index');
    }


    public function update(Request $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $product = $this->product_repo->update($request->all(), $product);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Error'], 500);
        }
        DB::commit();
        // return back();
        return redirect()->route('products.index');
    }


    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            $this->product_repo->destroy($product);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Error'], 500);
        }
        DB::commit();
        return back();
    }
}
