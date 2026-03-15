<?php

namespace App\Policies;

use App\Models\SaturaSaite;
use App\Models\User;

class SaturaSaitePolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function viewAny(User $user): bool { return $user->isEditor(); }
    public function view(User $user, SaturaSaite $saite): bool { return $user->isEditor(); }
    public function create(User $user): bool { return $user->isEditor(); }
    public function update(User $user, SaturaSaite $saite): bool { return $user->isEditor(); }
    public function delete(User $user, SaturaSaite $saite): bool { return $user->isEditor(); }

    // Optional explicit abilities you might call from controller:
    public function approve(User $user, SaturaSaite $saite): bool { return $user->isEditor(); }
    public function reject(User $user, SaturaSaite $saite): bool { return $user->isEditor(); }
}