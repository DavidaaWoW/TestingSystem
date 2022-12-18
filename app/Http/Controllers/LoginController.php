<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect(route('main'));
        }
        $formFields = $request->only(['email', 'password']);
        $remember = $request->only(['remember']);
        if (Auth::attempt($formFields, (bool)$remember)) {
            return redirect(route('main'));
        } else {
            return redirect(route('login'))->withErrors([
                'email' => 'Failed to authenticate'
            ]);
        }
    }
}
