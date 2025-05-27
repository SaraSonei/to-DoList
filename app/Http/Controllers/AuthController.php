<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
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
        $data = $request->validated();
        $user = User::create([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

       Auth::login($user);
       return redirect('/admin');
    }
}
