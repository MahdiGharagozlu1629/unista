<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->whereNotIn('id', [1])
            ->get();

        return view('Users::index', compact('users'));
    }

    public function create()
    {
        return view('Users::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'family' => ['required'],
            'username' => ['required', Rule::unique('users')->whereNotNull('deleted_at')],
            'email' => ['required', Rule::unique('users')->whereNotNull('deleted_at')],
            'password' => ['required','confirmed'],
            'phone' => ['required','max:11', Rule::unique('users')->whereNotNull('deleted_at')],
            'national_code' => ['required', Rule::unique('users')->whereNotNull('deleted_at')],
            'student_code' => ['required', Rule::unique('users')->whereNotNull('deleted_at')],
        ]);

        User::create([
            'name' => $request->name,
            'family' => $request->family,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'national_code' => $request->national_code,
            'student_code' => $request->student_code,
        ]);

        return redirect()->route('user.index')->with('success', 'عملیات موفقیت آمیز بود');
    }

    public function edit($id)
    {
        $user = User::query()->findOrFail($id);

        return view('Users::edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'family' => ['required'],
            'username' => ['required', Rule::unique('users')->ignore($id)->whereNotNull('deleted_at')],
            'email' => ['required', Rule::unique('users')->ignore($id)->whereNotNull('deleted_at')],
            'password' => ['required', 'confirmed'],
            'phone' => ['required', 'max:11', Rule::unique('users')->ignore($id)->whereNotNull('deleted_at')],
            'national_code' => ['required', Rule::unique('users')->ignore($id)->whereNotNull('deleted_at')],
            'student_code' => ['required', Rule::unique('users')->ignore($id)->whereNotNull('deleted_at')]
        ]);


        $user = User::query()->findOrFail($id);

        $user->update([
            'name' => $request->name,
            'family' => $request->family,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'national_code' => $request->national_code,
            'student_code' => $request->student_code,
        ]);

        return redirect()->route('user.index')->with('success', 'عملیات موفقیت آمیز بود');
    }

    public function destroy($id)
    {
        $user = User::query()->findOrFail($id);

        $user->delete();

        return redirect()->route('user.index')->with('success', 'عملیات موفقیت آمیز بود');
    }
}
