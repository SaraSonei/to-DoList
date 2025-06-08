<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLoginForm(){
        $errors = session('errors', new \Illuminate\Support\MessageBag);
        return view('admin.auth.login', compact('errors'));
    }

    public function login(LoginRequest $request)
    {

        $data = $request->validated();

        if (Auth::guard('admin')->attempt($data)) {
            $user = Auth::guard('admin')->user();

            if (!$user->isAdmin()) {
                Auth::guard('admin')->logout();
                return back()->withErrors(['email' => 'You are not an admin.']);
            }

            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'You are not allowed to enter this way.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login.form');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function showAdmins()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function showAllUsers()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })
            ->get();
        return view('admin.users.index', compact('users'));

    }
}
