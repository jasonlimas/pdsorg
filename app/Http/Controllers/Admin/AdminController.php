<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Sender;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Get users, senders, divisions from the database tables
        $users = User::paginate(5, ['*'], 'users');
        $senders = Sender::paginate(5, ['*'], 'senders');
        $divisions = Division::paginate(5, ['*'], 'divisions');

        return view('admin.index', [
            'users' => $users,
            'senders' => $senders,
            'divisions' => $divisions,
        ]);
    }
}
