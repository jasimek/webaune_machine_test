<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Repositories\CustomerRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Traits\AddToast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Throwable;

class OrderController extends Controller
{
    use AddToast;
    protected $order_repo;
    protected $customer_repo;
    protected $product_repo;

    public function __construct(
        OrderRepository $order_repo,
        CustomerRepository $customer_repo,
        ProductRepository  $product_repo
    ) {
        $this->order_repo = $order_repo;
        $this->product_repo = $product_repo;
        $this->customer_repo = $customer_repo;
    }

    public function index()
    {
        return Inertia::render('Admin/Order/Index', [
            'orders' => $this->order_repo->getAllOrders()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Order/Create', [
            'customers' => $this->customer_repo->getAllCustomers(),
            'products' => $this->product_repo->getAllProducts()
        ]);
    }


    public function store(Request $request)
    {

        // dd($request->all());
        DB::beginTransaction();
        try {
            $order = $this->order_repo->store($request->all());
        } catch (Throwable $th) {
            DB::rollBack();
            dd($th);
            $this->addToast('error', 'Error', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        Mail::to($order->customer->email)->send(new OrderConfirmationMail($order));
        $this->addToast('success', 'Success', 'Order Created Successfully');
        return back();
    }


    public function addToOrders(Request $request)
    {

        // dd($request->all());

        DB::beginTransaction();
        try {
            $order = $this->order_repo->addToOrders($request->all());
        } catch (Throwable $th) {
            DB::rollBack();
            dd($th);
            // return response()->json(['error' => $th->getMessage()], 500);
            return back()->withErrors($th->getMessage());
        }
        DB::commit();
        return back();
    }
}
