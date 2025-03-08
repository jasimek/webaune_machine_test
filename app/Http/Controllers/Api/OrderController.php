<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $order_repo;

    public function __construct(OrderRepository  $order_repo)
    {
        $this->order_repo = $order_repo;
    }

    public function getAllOrders()
    {

        return response()->json(['orders' => $this->order_repo->getAllOrders()]);
    }
}
