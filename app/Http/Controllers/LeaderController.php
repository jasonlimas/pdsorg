<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderController extends Controller
{
    public function index()
    {
        // Get current logged in user (Team Leader)
        $loggedInUser = auth()->user();

        // Get users from the database users table, only users from the same division as the logged in user
        $users = User::where('division_id', $loggedInUser->division_id)->paginate(5);

        return view('user.leader.index', [
            'users' => $users,
        ]);
    }
}
