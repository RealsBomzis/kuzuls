<?php

namespace App\Policies;

use App\Models\KontaktZinojums;
use App\Models\User;

class ContactMessagePolicy
{
    public function before(User $user, string $ability): bool|null
    {
        // Admin can do everything
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        // Allow editors too
        return method_exists($user, 'isEditor') && $user->isEditor();
    }

    public function view(User $user, KontaktZinojums $msg): bool
    {
        return method_exists($user, 'isEditor') && $user->isEditor();
    }

    public function update(User $user, KontaktZinojums $msg): bool
    {
        return method_exists($user, 'isEditor') && $user->isEditor();
    }

    public function delete(User $user, KontaktZinojums $msg): bool
    {
        return method_exists($user, 'isEditor') && $user->isEditor();
    }
}