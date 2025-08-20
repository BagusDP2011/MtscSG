<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function user()
    {
        $users = User::all(); // atau bisa pakai pagination
        return view('admin.user.user', compact('users'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'staff',
        ]);

        return redirect()->back()->with('success', 'User successfully added.');
    }
}
