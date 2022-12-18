<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function makeAdmin(){
        $user = Auth::user();
        $role = Role::where('name', '=', 'admin')->first();
        if(!$user->roles->contains($role))
            $user->roles()->attach($role, ['id' => uniqid()]);
        return view('user.main');
    }

    public function makeTeacher(){
        $user = Auth::user();
        $role = Role::where('name', '=', 'teacher')->first();
        $admin = Role::where('name', '=', 'admin')->first();
        if(!$user->roles->contains($role))
            $user->roles()->attach($role, ['id' => uniqid()]);
            $user->roles()->detach($admin->id);
        return view('user.main');
    }

    public function makeUser(){
        $user = Auth::user();
        $role = Role::where('name', '=', 'teacher')->first();
        $admin = Role::where('name', '=', 'admin')->first();
        $user_role = Role::where('name', '=', 'user')->first();
        $user->roles()->detach([$admin->id, $role->id]);
        if(!$user->roles->contains($user_role))
            $user->roles()->attach($user_role, ['id' => uniqid()]);
        return view('user.main');
    }
}
