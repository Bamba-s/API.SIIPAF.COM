<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $targetUser)
    {
        return $user->isAdmin() && !$targetUser->isAdmin();
    }

    public function delete(User $user, User $targetUser)
    {
        return $user->isAdmin() && !$targetUser->isAdmin();
    }
}
