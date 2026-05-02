<?php

namespace App\Policies;

use App\Models\System;
use App\Models\User;

class SystemPolicy
{
    public function viewAny(User $user): bool
    {
        return ! empty($user->id);
    }

    public function view(User $user, System $system): bool
    {
        return ! empty($user->id);
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, System $system): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, System $system): bool
    {
        return $user->isAdmin();
    }
}
