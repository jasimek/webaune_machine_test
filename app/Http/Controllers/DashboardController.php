<?php

namespace App\Http\Controllers;

use App\Consts\QualityIndicatorDataTypes;
use App\Repositories\AuditRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\DashboardRepository;
use App\Repositories\IncidentRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\QualityIndicatorRepository;
use App\Traits\AddToast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Throwable;

class DashboardController extends Controller
{
    use AddToast;
    protected $customer_repo;
    protected $product_repo;
    protected $order_repo;


    public function __construct(
        OrderRepository $order_repo,
        ProductRepository $product_repo,
        CustomerRepository $customer_repo
    ) {
        $this->customer_repo = $customer_repo;
        $this->product_repo = $product_repo;
        $this->order_repo = $order_repo;
    }

    public function index()
    {
        return Inertia::render('Dashboard/Index', [
            'order_count' => $this->order_repo->getAllOrders()->count(),
            'orders' => $this->order_repo->getAllOrders(),
            'product_count' => $this->product_repo->getAllProducts()->count(),
            'products' => $this->product_repo->getAllProducts(),
            'customer_count' => $this->customer_repo->getAllCustomers()->count(),
            'customers' => $this->customer_repo->getAllCustomers()
        ]);
    }
}
