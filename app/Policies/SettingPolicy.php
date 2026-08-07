<?php

namespace App\Policies;

use App\Models\User;

class SettingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    public function view(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    public function update(User $user): bool
    {
        return $user->hasRole('Admin');
    }
}