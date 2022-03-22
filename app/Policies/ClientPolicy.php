<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    // Policy for deleting a client
    public function delete(User $user)
    {
        // Only users with role admin and team leader can delete a client
        return $user->role_id == 1 || $user->role_id == 2;
    }

    // Policy for editing a client
    public function edit(User $user)
    {
        // Only users with role admin and team leader can edit a client
        return $user->role_id == 1 || $user->role_id == 2;
    }
}
