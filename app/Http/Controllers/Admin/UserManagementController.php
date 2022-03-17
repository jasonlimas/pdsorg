<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Role;
use App\Models\Sender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function show(User $user)
    {
        $roles = Role::all();
        $organizations = Sender::all();
        $divisions = Division::all();

        return view('user.edit', [
            'user' => $user,
            'roles' => $roles,
            'organizations' => $organizations,
            'divisions' => $divisions,
        ]);
    }

    // Update an user in the database. Called when clicking the edit icon
    public function update(Request $request, User $user)
    {
        // Validation
        $this->validate($request, [
            'name' => 'required|string|max:120',
            'name_abbreviation' => 'required|string|max:5',
            'email' => 'required|string|email|max:120|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:30',
            'new_password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'organization_id' => 'required|exists:senders,id',
            'division_id' => 'required|exists:divisions,id',
        ]);

        // Update the user
        $password = $user->password;    // Get the hash of old password
        if ($request->new_password) {
            // If the new password is not empty, get the hash of the new password
            $password = Hash::make($request->new_password);
        }

        $user->update([
            'name' => $request->name,
            'name_abbreviation' => $request->name_abbreviation,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'role_id' => $request->role_id,
            'sender_id' => $request->organization_id,
            'division_id' => $request->division_id,
        ]);

        return redirect()->route('admin')->with('success', 'User ' . $request->name . ' edited successfully');
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
