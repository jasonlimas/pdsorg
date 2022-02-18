<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sender;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Get users from the database users table
        $users = User::paginate(5, ['*'], 'users');
        $senders = Sender::paginate(5, ['*'], 'senders');

        return view('admin.index', [
            'users' => $users,
            'senders' => $senders,
        ]);
    }
}
