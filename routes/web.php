<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Customer\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';

// admin login
Route::get('admin/login', [UserController::class, 'userLoginPage'])->name('login')->middleware('guest');
Route::post('users/login', [UserController::class, 'userLogin'])->name('user.login')->middleware('guest');

// customer login
Route::get('/login', [LoginController::class, 'loginPage'])->name('customer_login')->middleware('guest');
Route::post('customer/login', [LoginController::class, 'login'])->name('customer.login')->middleware('guest');

// home
Route::get('/', [HomeController::class, 'index'])->name('home');


//admin authenticated
Route::group(['middleware' => ['auth:web']], function () {
    Route::group(['prefix' => 'admin/'], function () {

        // logout
        Route::post('logout', [UserController::class, 'logout'])->name('admin.logout');

        // dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        //customer
        Route::resource('customers', CustomerController::class)->names('customers');

        //product
        Route::resource('products', ProductController::class)->names('products');

        //orders
        Route::resource('orders', OrderController::class)->names('orders');
    });
});

//customer authenticated
Route::group(['middleware' => ['auth:customer']], function () {

    // logout
    Route::post('logout', [LoginController::class, 'logout'])->name('customer.logout');

    //cart
    Route::post('add-to-carts', [CartController::class, 'addToCart'])->name('customer.add_to_cart');
    Route::get('carts', [CartController::class, 'index'])->name('customer.carts');
    Route::post('remove-cart-item/{cart}', [CartController::class, 'removeFromCart'])->name('customer.remove_from_carts');
    Route::post('increase-or-decrease-cart-item/{cart}', [CartController::class, 'increaseOrDecreaseQuantity'])->name('customer.increase_or_decrease_quantity');
});
