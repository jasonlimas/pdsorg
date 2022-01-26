<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Validate the user input
        // (not attempting to login yet. just checking if the input is valid)
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        // Attempt to login the user with given input (username and password)
        if (!auth()->attempt($request->only('username', 'password'))) {
            // Redirect back to the login page, plus passing error message
            // Telling the user that the login details given is invalid
            return back()->with('status', 'Invalid login details');
        }

        // After successful login attempt, redirect user to home page
        return redirect()->route('home');
    }
}
