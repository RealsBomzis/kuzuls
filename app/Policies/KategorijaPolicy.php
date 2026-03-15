<?php

namespace App\Policies;

use App\Models\Kategorija;
use App\Models\User;

class KategorijaPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function viewAny(User $user): bool { return $user->isEditor(); }
    public function view(User $user, Kategorija $kategorija): bool { return $user->isEditor(); }
    public function create(User $user): bool { return $user->isEditor(); }
    public function update(User $user, Kategorija $kategorija): bool { return $user->isEditor(); }
    public function delete(User $user, Kategorija $kategorija): bool { return $user->isEditor(); }
}