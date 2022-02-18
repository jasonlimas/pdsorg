<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    // Update an user in the database. Called when clicking the edit icon
    public function update(Request $request, User $user)
    {
        // TODO: Validate input

        // TODO: Update the database
    }

    // Delete selected user
    public function destroy(User $user)
    {
        // Delete the user from the database
        $user->delete();

        // Redirect back with success message
        return back()->with('status', 'User deleted successfully');
    }
}
