<?php

namespace App\Policies;

use App\Models\Desa;
use App\Models\User;

class DesaPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Desa $desa): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    public function update(User $user, Desa $desa): bool
    {
        return $user->hasRole('Admin');
    }

    public function delete(User $user, Desa $desa): bool
    {
        return $user->hasRole('Admin');
    }
}