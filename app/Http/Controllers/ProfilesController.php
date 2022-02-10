<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index()
    {
        $clients = Client::paginate(7);

        return view('profiles', [
            'user' => auth()->user(),
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
