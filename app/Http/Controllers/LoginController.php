<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Responses\LoginResponse;


class LoginController extends Controller
{
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email'    => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return back()->with('error', 'Email atau password salah');
    //     }

    //     Auth::login($user);

    //     return (new LoginResponse($request))->toResponse();
    // }


    // public function logout()
    // {
    //     Auth::logout();
    //     return redirect('/user/login');
    // }
}
