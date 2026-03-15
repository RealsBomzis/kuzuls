<?php

namespace App\Policies;

use App\Models\Galerija;
use App\Models\User;

class GalerijaPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function viewAny(User $user): bool { return $user->isEditor(); }
    public function view(User $user, Galerija $galerija): bool { return $user->isEditor(); }
    public function create(User $user): bool { return $user->isEditor(); }
    public function update(User $user, Galerija $galerija): bool { return $user->isEditor(); }
    public function delete(User $user, Galerija $galerija): bool { return $user->isEditor(); }
}