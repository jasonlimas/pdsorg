<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        // Prevent unauthenticated users from accessing the page
        $this->middleware(['auth'])->only(['createIndex', 'editIndex', 'store', 'destroy']);
    }

    // Return the client create view
    public function index()
    {
        return view('client.create');
    }

    public function show(Client $client)
    {
        return view('client.edit', [
            'client' => $client
        ]);
    }

    // Add a new client to the database. Called when clicking the add client button
    public function store(Request $request)
    {
        // Validation
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric',
            'address' => 'required|max:255',
        ]);

        // Create client
        $request->user()->clients()->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Redirect back with success message
        return back()->with('status', 'Client created successfully');
    }

    // Update a client in the database. Called when clicking the edit client button
    public function update(Request $request, Client $client)
    {
        // Validation
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required|max:255',
        ]);

        // Update client
        $client->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Redirect back with success message
        return back()->with('status', 'Client updated successfully');
    }

    // Delete a client from the database. Called when clicking the delete icon
    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);    // Make sure the user is authorized to delete the client
        $client->delete();                      // Delete the client

        // Redirect back with success message
        return back()->with('status', 'Client deleted successfully');
    }
}
