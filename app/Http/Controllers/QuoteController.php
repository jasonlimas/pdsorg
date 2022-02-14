<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index()
    {
        return view('quote.index');
    }
}
