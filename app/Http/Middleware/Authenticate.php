<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (Auth::guard('customer')->name == 'customer') {
            return route('customer_login');
        } else if (Auth::guard('web')->name == 'web') {
            return route('login');
        }
        // return $request->expectsJson() ? null : route('customer_login');
    }
}
