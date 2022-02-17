<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        // Prevent authenticated users from accessing the login page
        $this->middleware('guest');
    }

    public function index()
    {
        // Save the previous URL in the session so we can return to it after logging in
        session(['url.intended' => url()->previous()]);
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Validate the user input
        // (not attempting to login yet. just checking if the input is valid)
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        // Attempt to login the user with given input (username and password)
        if (!auth()->attempt($request->only('email', 'password'))) {
            // Redirect back to the login page, plus passing error message
            // Telling the user that the login details given is invalid
            return back()->with('status', 'Invalid login details');
        }

        // After successful login attempt, redirect user to previous page before login, or to
        // home page if no previous page is found
        return redirect()->intended(route('home'));
    }
}
