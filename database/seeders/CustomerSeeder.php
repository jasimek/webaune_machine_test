<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Customer::count()) {
            $customer = Customer::updateOrCreate(
                ['id' => 1],
                [
                    'name' => 'customer',
                    'email' => 'customer@mail.com',
                    'phone' => '123456789',
                    'password' => Hash::make('123456')
                ]
            );
        }
    }
}
