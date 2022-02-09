<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateQuoteController extends Controller
{
    public function index()
    {
        return view('quote.create');
    }

    public function store(Request $request)
    {
        dd($request);

        // Validate input, make sure there is no blank input

    }
}
