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
        if (auth()->user()->role_id == 1) {
            $roles = Role::all();
            $organizations = Sender::all();
            $divisions = Division::all();

            return view('user.edit', [
                'user' => $user,
                'roles' => $roles,
                'organizations' => $organizations,
                'divisions' => $divisions,
            ]);
        } else if (auth()->user()->role_id == 2) {
            return view('user.edit', [
                'user' => $user,
            ]);
        }
    }

    public function updatePassword(Request $request)
    {
        // Validation
        $this->validate($request, [
            'oldPassword' => 'required|password',   // 'password' in the validation means the current password
            'newPassword' => 'required|min:8|confirmed',
        ]);

        // Update password
        $user = User::find(auth()->user()->id);
        $user->update([
            'password' => Hash::make($request->newPassword),
        ]);

        // Redirect to profiles page with success message
        return redirect()->route('profiles')->with('status', 'Password updated successfully');
    }

    // Update an user in the database. Called when clicking the edit icon
    public function update(Request $request, User $user)
    {
        if (auth()->user()->role_id == 1) {
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
        } else if (auth()->user()->role_id == 2) {
            // Validation
            $this->validate($request, [
                'name' => 'required|string|max:120',
                'name_abbreviation' => 'required|string|max:5',
                'email' => 'required|string|email|max:120|unique:users,email,' . $user->id,
                'phone' => 'required|string|max:30',
                'new_password' => 'nullable|string|min:8|confirmed',
                // No need to validate roles, organization, divisions because these are not editable
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
                // Roles, organization, division remain the same
            ]);

            return redirect()->route('leader')->with('success', 'User ' . $request->name . ' edited successfully');
        }
    }

    // Delete selected user
    public function destroy(User $user)
    {
        // Delete the user from the database
        $user->delete();

        // Redirect back with success message
        return back()->with('success', 'User deleted successfully');
    }
}
