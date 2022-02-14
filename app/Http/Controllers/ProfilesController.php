<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Sender;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index()
    {
        // Get senders and clients from the database
        $senders = Sender::latest()->paginate(5, ['*'], 'senders');
        $clients = Client::latest()->paginate(5, ['*'], 'clients');

        return view('profiles', [
            'user' => auth()->user(),
            'senders' => $senders,
            'clients' => $clients,
        ]);
    }

    // Update the user profile
    public function update(Request $request)
    {
        // Validation
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ]);

        $user = User::find(auth()->user()->id);

        // Update
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Redirect back with success message
        return back()->with('status', 'User updated successfully');
    }
}
