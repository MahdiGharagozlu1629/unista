<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $user = User::query()
            ->where('username' , $request->username)
            ->firstOrFail();

        if (Hash::check($request->password , $user->password))
            Auth::login($user);
        else
            return redirect()->back()->with('error' , 'username or password not match');

        return redirect()->route('admin.index');
    }

    public function clientLogin()
    {
        return view('client.login');
    }

    public function loginToClient(Request $request)
    {
        $user = User::query()->where('username' , $request->username)->firstOrFail();

        if (Hash::check($request->password , $user->password))
            Auth::guard('client')->login($user);
        else
            return redirect()->back()->with('error' , 'نام کاربری یا رمز عبور اشتباه است');

        return redirect()->route('index');
    }
}
