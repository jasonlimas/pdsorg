<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Sender;
use Illuminate\Http\Request;

class CreateQuoteController extends Controller
{
    public function index()
    {
        // Get senders and clients from the database
        $senders = Sender::all();
        $clients = Client::all();

        return view('quote.create', [
            'senders' => $senders,
            'clients' => $clients,
        ]);
    }

    public function store(Request $request)
    {
        dd($request);

        // Validate input, make sure there is no blank input

    }
}
