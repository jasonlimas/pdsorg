<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SenderPolicy
{
    use HandlesAuthorization;

    public function delete(User $user)
    {
        return $user->role_id === 1;
    }

    public function edit(User $user)
    {
        return $user->role_id === 1;
    }
}
