<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Sertifikat;

class SertifikatPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Sertifikat $sertifikat): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Sertifikat $sertifikat): bool
    {
        return true;
    }

    public function delete(User $user, Sertifikat $sertifikat): bool
    {
        return $user->hasRole('Admin');
    }

    public function restore(User $user, Sertifikat $sertifikat): bool
    {
        return $user->hasRole('Admin');
    }

    public function forceDelete(User $user, Sertifikat $sertifikat): bool
    {
        return $user->hasRole('Admin');
    }
}
