<?php

namespace App\Http\Controllers;

use App\Models\Sender;
use Illuminate\Http\Request;

class SenderController extends Controller
{
    public function __construct()
    {
        // Prevent unauthenticated users from accessing the page
        $this->middleware(['auth'])->only(['index', 'store', 'show', 'destroy']);
    }

    // Create Sender Organization Profile page
    public function index()
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

    // Show Sender Organization Profile
    public function show(Sender $sender)
    {
        return view('sender.edit', [
            'sender' => $sender
        ]);
    }

    // Update Sender Organization Profile
    public function update(Request $request, Sender $sender)
    {
        // Validation
        $this->validate($request, [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
        ]);

        // Update Sender Organization Profile
        $sender->update([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        // Redirect back with success message
        return back()->with('status', 'Sender Organization Profile updated successfully');
    }

    // Destroy Sender Organization Profile
    public function destroy(Sender $sender)
    {
        //$this->authorize('delete', $sender);    // Make sure the user is authorized to delete the client
        $sender->delete();                      // Delete Sender Organization Profile

        // Redirect back with success message
        return back()->with('status', 'Sender Organization Profile deleted successfully');
    }
}
