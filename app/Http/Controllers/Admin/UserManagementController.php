<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Role;
use App\Models\Sender;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function show(User $user)
    {
        $roles = Role::all();
        $organizations = Sender::all();
        $divisions = Division::all();

        return view('admin.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'organizations' => $organizations,
            'divisions' => $divisions,
        ]);
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
