<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $data = $request->validated();

        if(!auth::attempt($data))
        {
            throw ValidationException::withMessages(['email' => 'The provided credentials do not match our records']);
        }

        $user = Auth::user();

        if ($user->isAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'You are not allowed to enter this way.',
            ]);
        }


        $request->session()->regenerate();

        return redirect('/dashboard');

    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/login');
    }
}
