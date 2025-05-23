<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'regex:/[0-9]/',          
                'regex:/[@$!%*?&.]/',       
            ],
            'username' => 'required|string|unique:users,username|min:3',
        ], [
            'email.email' => 'The email must be a valid email address.',
            'password.regex' => 'The password must contain at least one number and one special character.',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
        ]);
    
        Auth::login($user);
    
        return redirect()->route('personal');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showUserHome()
    {
        return view('user.personal');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            
            return redirect()->route('dashboard');
        }
    
        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function home()
    {
        return view('home');
    }
}
