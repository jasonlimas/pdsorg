<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function store()
    {
        // Log the user out
        auth()->logout();

        // Redirect the user back to the home page after a successful logout
        return redirect()->route('home');
    }
}
