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
            'role'     => 'required|in:admin,staff',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->back()->with('success', 'User successfully added.');
    }
    // update user
    public function editUser(Request $request, $id)
    {
        $user = User::where('user_id', $id)->firstOrFail();

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email',
            'role'  => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', 'User updated successfully');
    }


    // delete user
    public function deleteUser($id)
    {

        // proteksi user sistem
        if (in_array($id, [1, 2, 3])) {
            return redirect()->back()->with('error', 'System users cannot be deleted');
        }

        $user = User::where('user_id', $id)->firstOrFail();
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
