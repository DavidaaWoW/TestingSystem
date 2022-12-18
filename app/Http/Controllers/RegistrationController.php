<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class RegistrationController extends Controller
{
    function register(Request $request){
        if (Auth::check()) {
            return redirect(route('main'));
        }
        $validateFields = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'code' => 'required|unique:users,code',
            'name' => 'required'
        ]);
        $id = uniqid();
        $validateFields = array('id' => $id) + $validateFields;
        $user = User::create($validateFields);
        $user->roles()->attach(Role::where('name', '=', 'user')->first(), ['id' => uniqid()]);
        if ($user) {
            Auth::login($user, (bool)$request->remember);
            $json = json_encode(array('language' => "ru"));
            Redis::set($user->id, $json);
            return redirect(route('main'));
        } else {
            return redirect(route('registration'))->withErrors([
                'formError' => 'Ошибка при аутентификации'
            ]);
        }
    }
}
