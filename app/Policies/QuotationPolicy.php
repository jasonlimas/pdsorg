<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuotationPolicy
{
    use HandlesAuthorization;

    // Policy for deleting a quotation
    public function delete(User $user)
    {
        // Only users with role admin and team leader can delete a quote
        return $user->role_id === 1 || $user->role_id === 2;
    }

    // Policy for editing a quotation
    public function edit(User $user)
    {
        // Only users with role admin and team leader can edit a quote
        return $user->role_id === 1 || $user->role_id === 2;
    }
}
