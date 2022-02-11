<?php

namespace App\Http\Controllers;

use App\Models\Sender;
use Illuminate\Http\Request;

class SenderController extends Controller
{
    public function __construct()
    {
        // Prevent unauthenticated users from accessing the page
        $this->middleware(['auth'])->only(['createIndex', 'store', 'destroy']);
    }

    // Create Sender Organization Profile page
    public function createIndex()
    {
        return view('sender.create');
    }

    // Store Sender Organization Profile
    public function store(Request $request)
    {
        // Validation
        $this->validate($request, [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
        ]);

        // Create Sender Organization Profile
        Sender::create([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        // Redirect back with success message
        return back()->with('status', 'Sender Organization Profile created successfully');
    }
}
