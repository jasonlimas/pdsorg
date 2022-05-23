<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Division;
use App\Models\Sender;
use App\Models\TermsConditions;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index()
    {
        // Get sender organization details based on logged in user
        $sender = Sender::withTrashed()->find(auth()->user()->sender_id);

        // Get clients and termsConditions from the database
        // For admin, get all clients, for other users, get only clients from that division
        if (auth()->user()->role_id == 1) {
            $clients = Client::latest()->paginate(5, ['*'], 'clients');
        } else {
            $clients = Client::where('division_id', auth()->user()->division_id)->latest()->paginate(5, ['*'], 'clients');
        }

        $terms = TermsConditions::latest()->paginate(5, ['*'], 'terms');

        // Get user's division details
        $division = Division::withTrashed()->find(auth()->user()->division_id)->description;

        return view('profiles', [
            'user' => auth()->user(),
            'sender' => $sender,
            'clients' => $clients,
            'terms' => $terms,
            'division' => $division,
        ]);
    }

    public function indexPassword()
    {
        $user = auth()->user();
        return view('user.change-password', [
            'user' => $user,
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
