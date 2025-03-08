<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Throwable;

class CartController extends Controller
{

    protected $cart_repo;

    public function __construct(CartRepository $cart_repo)
    {
        $this->cart_repo = $cart_repo;
    }


    public function index()
    {
        return Inertia::render('Home/Cart', [
            'cart_items' => Cart::where('customer_id', Auth::guard('customer')->user()->id)->with('product', 'customer')->get()
        ]);
    }

    public function addToCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $cart = $this->cart_repo->addToCart($request->all());
        } catch (Throwable $th) {
            DB::rollBack();
            dd($th);
            // return response()->json(['message' => 'Error'], 500);

            return back();
        }
        DB::commit();
        // return response()->json(['message' => 'Success'], 200);
        return redirect()->route('customer.carts');
    }

    public function removeFromCart(Request $request, Cart $cart)
    {


        DB::beginTransaction();
        try {

            $cart =   $this->cart_repo->removeFromCart($cart);
        } catch (Throwable $th) {
            DB::rollBack();
            dd($th);
            return back();
        }
        DB::commit();
        return redirect()->route('customer.carts');
    }

    public function increaseOrDecreaseQuantity(Request $request, Cart $cart)
    {

        DB::beginTransaction();
        try {
            $cart = $this->cart_repo->increaseOrDecreaseQuantity($request->all(), $cart);
        } catch (Throwable $th) {
            DB::rollBack();
            // return back()->withErrors($th->getMessage());

            return response()->json(['message'=>$th->getMessage()]);
        }
        DB::commit();
        return redirect()->route('customer.carts');
    }
}
