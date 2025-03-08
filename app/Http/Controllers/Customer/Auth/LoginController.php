<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Throwable;

class LoginController extends Controller
{
    public function loginPage()
    {
        return Inertia::render('Customer/Auth/Login');
    }

    public function login(Request $request)
    {

        // dd($request->all());

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        try {
            if (Auth::guard('customer')->attempt($credentials)) {
                $request->session()->regenerate();

                // dd('here');

                return redirect()->route('home');
            }
        } catch (Throwable $th) {
        }

        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

    public function forgotPassword()
    {
        return Inertia::render('Auth/ForgotPassword');
    }


    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('customer_login');
    }

    public function profile()
    {
        return Inertia::render('Profile/Edit');
    }
}
