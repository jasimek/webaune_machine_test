<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Media;
use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CustomerRepository
{

    public function store($data)
    {
        $this->validateData($data);
        $customer = Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address']

        ]);

        return  $customer;
    }


    public function update($data, $customer)
    {
        $this->validateData($data, true);
        $customer->name = $data['name'];
        $customer->email = $data['email'];
        $customer->phone = $data['phone'];
        $customer->address = $data['address'];
        return $customer;
    }

    public function getAllCustomers()
    {
        return Customer::all();
    }


    public function destroy($customer)
    {

        $customer->delete();

        return $customer;
    }

    public function validateData($data, $for_update = false)
    {


        $rules = [
            'name'  => 'required',
            'email' => 'required',
            'phone' => [
                'required',
                'numeric',
                $for_update ? Rule::unique('customers', 'phone')->ignore($data['id']) : Rule::unique('customers', 'phone')
            ],
        ];

        validator($data, $rules)->validate();
    }
}
