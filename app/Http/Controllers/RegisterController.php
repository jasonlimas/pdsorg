<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Role;
use App\Models\Sender;
use Illuminate\Http\Request;

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
}
