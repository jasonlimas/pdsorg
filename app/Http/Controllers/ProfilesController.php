<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index()
    {
        $clients = Client::paginate(7);

        return view('profiles', [
            'clients' => $clients,
        ]);
    }
}
