<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{

    public function create()
    {
        return view('auth.register');
    }
    public function store(RegisterRequest $request)
    {

        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => $request->password,
        ]);

       Auth::login($user);
       return redirect('/admin');




        return response()->json(['message' => 'Register successfully'], 201);
        //return view('auth.login');

    }
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

    }
}
