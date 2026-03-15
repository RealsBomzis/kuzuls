<?php

namespace App\Policies;

use App\Models\Pasakums;
use App\Models\User;

class PasakumsPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function viewAny(User $user): bool { return $user->isEditor(); }
    public function view(User $user, Pasakums $pasakums): bool { return $user->isEditor(); }
    public function create(User $user): bool { return $user->isEditor(); }
    public function update(User $user, Pasakums $pasakums): bool { return $user->isEditor(); }
    public function delete(User $user, Pasakums $pasakums): bool { return $user->isEditor(); }
    public function restore(User $user, Pasakums $pasakums): bool { return false; }
    public function forceDelete(User $user, Pasakums $pasakums): bool { return false; }
}