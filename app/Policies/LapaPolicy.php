<?php

namespace App\Policies;

use App\Models\Lapa;
use App\Models\User;

class LapaPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function viewAny(User $user): bool { return $user->isEditor(); }
    public function view(User $user, Lapa $lapa): bool { return $user->isEditor(); }
    public function create(User $user): bool { return $user->isEditor(); }
    public function update(User $user, Lapa $lapa): bool { return $user->isEditor(); }
    public function delete(User $user, Lapa $lapa): bool { return $user->isEditor(); }
}