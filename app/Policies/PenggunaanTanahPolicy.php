<?php

namespace App\Policies;

use App\Models\PenggunaanTanah;
use App\Models\User;

class PenggunaanTanahPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    public function update(User $user, PenggunaanTanah $penggunaanTanah): bool
    {
        return $user->hasRole('Admin');
    }

    public function delete(User $user, PenggunaanTanah $penggunaanTanah): bool
    {
        return $user->hasRole('Admin');
    }
}