<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use App\Traits\AddToast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Throwable;

class CustomerController extends Controller
{
    use AddToast;
    protected $customer_repo;

    public function __construct(CustomerRepository $customer_repo)
    {
        $this->customer_repo = $customer_repo;
    }


    public function index()
    {
        return Inertia::render('Admin/Customer/Index', [
            'customers' => $this->customer_repo->getAllCustomers()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Customer/Create');
    }

    public function edit(CUstomer $customer)
    {
        return Inertia::render('Admin/Customer/Edit', [
            'customer' => $customer
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->customer_repo->store($request->all());
        } catch (Throwable $th) {
            DB::rollBack();
            // dd($th);
            throw $th;
            $this->addToast('error', 'Error', 'Something Went Wrong');
            // return response()->json(['error' => $th->getMessage()], 500);
            return back();
        }
        DB::commit();
        $this->addToast('success', 'Success', 'Customer Created Successfully');
        return back();
        // return response()->json(['message' => 'Customer created successfully'], 201);
    }


    public function update(Request $request, Customer $customer)
    {

        DB::beginTransaction();
        try {
            $this->customer_repo->update($request->all(), $customer);
        } catch (Throwable $th) {
            DB::rollBack();
            // dd($th);
            throw $th;
            $this->addToast('error', 'Error', 'Something Went Wrong');
            // return response()->json(['error' => $th->getMessage()], 500);
            return back();
        }
        DB::commit();
        $this->addToast('success', 'Success', 'Customer Updated Successfully');
        return back();
        // return response()->json(['message' => 'Customer created successfully'], 201);


    }

    public function destroy(Customer  $customer)
    {

        DB::beginTransaction();
        try {
            $this->customer_repo->destroy($customer);
        } catch (Throwable $th) {
            DB::rollBack();
            $this->addToast('error', 'Error', 'Something Went Wrong');
            // return response()->json(['error' => $th->getMessage()], 500);
            return back();
        }
        DB::commit();
        $this->addToast('success', 'Success', 'Customer Deleted Successfully');
        return back();
        // return response()->json(['message' => 'Customer created successfully'], 201);

    }
}
