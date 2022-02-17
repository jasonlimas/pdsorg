<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Role;
use App\Models\Sender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $organizations = Sender::all();
        $divisions = Division::all();

        return view('admin.user.create', [
            'roles' => $roles,
            'organizations' => $organizations,
            'divisions' => $divisions,
        ]);
    }

    public function store(Request $request)
    {
        // Validation
        $this->validate($request, [
            'name' => 'required|string|max:120',
            'name_abbreviation' => 'required|string|max:10',
            'email' => 'required|string|email|max:120|unique:users',
            'phone' => 'required|string|max:30',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'organization_id' => 'required|exists:senders,id',
            'division_id' => 'required|exists:divisions,id',
        ]);

        // Create User
        User::create([
            'name' => $request->name,
            'name_abbreviation' => $request->name_abbreviation,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'sender_id' => $request->organization_id,
            'division_id' => $request->division_id,
        ]);

        // Redirect back to /admin/users page
        return redirect()->route('admin')->with('success', 'User ' . $request->name . ' created successfully');
    }
}
