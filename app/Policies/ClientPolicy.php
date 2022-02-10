<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Client $client)
    {
        return $user->id === $client->user_id;
    }

    public function edit(User $user, Client $client)
    {
        return $user->id === $client->user_id;
    }
}
