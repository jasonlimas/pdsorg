<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderController extends Controller
{
    public function index()
    {
        // Get users from the database users table
        $users = User::paginate(5, ['*'], 'users');

        return view('leader.index', [
            'users' => $users,
        ]);
    }
}
