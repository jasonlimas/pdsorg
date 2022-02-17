<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Sender;
use App\Models\TermsConditions;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index()
    {
        // Get sender organization details based on logged in user
        $sender = Sender::find(auth()->user()->sender_id);
        //dd($sender);

        // Get clients and termsConditions from the database
        $clients = Client::latest()->paginate(5, ['*'], 'clients');
        $terms = TermsConditions::latest()->paginate(5, ['*'], 'terms');

        return view('profiles', [
            'user' => auth()->user(),
            'sender' => $sender,
            'clients' => $clients,
            'terms' => $terms,
        ]);
    }

    // Update the user profile
    public function update(Request $request)
    {
        // Validation
        $this->validate($request, [
            'phone' => 'required|numeric',
        ]);

        $user = User::find(auth()->user()->id);

        // Update
        $user->update([
            'phone' => $request->phone,
        ]);

        // Redirect back with success message
        return back()->with('status', 'User updated successfully');
    }
}
