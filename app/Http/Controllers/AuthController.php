<?php

// app/Http/Controllers/AuthController.php

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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'regex:/[0-9]/',           // Ensure the password has at least one number
                'regex:/[@$!%*?&.]/',        // Ensure the password has at least one special character
            ],
        ], [
            // Custom validation messages
            'email.email' => 'The email must be a valid email address.',
            'password.regex' => 'The password must contain at least one number and one special character.',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        Auth::login($user);
    
        return redirect()->route('home');
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate the login input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('personal');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Handle the logout request
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
