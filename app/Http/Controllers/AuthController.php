<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Process the login attempt
    public function login(Request $request)
    {
        // Validate the incoming data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Auth::attempt() automatically has the provided password and checks the database
        if (Auth::attempt($credentials)) {
            // Security best practice: prevent session fixation attacks
            $request->session()->regenerate();

            // Redirect them to the users dashboard we built earlier
            return redirect()->intended('dashboard');
        }

        // If it fails, send them back with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // 3. Handle logging out
    public function logout(Request $request)
    {
        Auth::logout();

        // Destroy the session completely
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}