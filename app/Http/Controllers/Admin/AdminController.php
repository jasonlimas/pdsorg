<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Sender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // Get users, senders, divisions from the database tables
        $users = User::paginate(5, ['*'], 'users');
        $senders = Sender::paginate(5, ['*'], 'senders');
        $divisions = Division::paginate(5, ['*'], 'divisions');
        $tax = DB::table('app_settings')->where('setting_name', 'tax')->first()->setting_value;

        return view('user.admin.index', [
            'users' => $users,
            'senders' => $senders,
            'divisions' => $divisions,
            'tax' => $tax,
        ]);
    }

    public function updateTax(Request $request)
    {
        // Validate the request
        $request->validate([
            'tax' => 'required|numeric|min:0|max:100',
        ]);

        // Update the tax in the database
        DB::table('app_settings')->where('setting_name', 'tax')->update(['setting_value' => $request->tax]);

        // Redirect to the admin page
        return redirect()->route('admin')->with('status', 'Settings updated successfully');
    }
}
