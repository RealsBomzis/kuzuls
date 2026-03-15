<?php

namespace App\Policies;

use App\Models\KontaktZinojums;
use App\Models\User;

class KontaktZinojumuPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->isEditor();
    }

    public function view(User $user, KontaktZinojums $msg): bool
    {
        return $user->isEditor();
    }

    public function update(User $user, KontaktZinojums $msg): bool
    {
        return $user->isEditor();
    }

    public function delete(User $user, KontaktZinojums $msg): bool
    {
        return $user->isEditor();
    }
}