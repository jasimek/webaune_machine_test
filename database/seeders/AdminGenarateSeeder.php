<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminGenarateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::count()) {
            $user = User::create([
                'id' => 1,
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@mail.com',
                'phone' => '123456789',
                'password' => Hash::make('123456')
            ]);
        }else $user = User::find(1);

        $user->assignRole('Super Admin');


    }
}
