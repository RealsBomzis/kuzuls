<?php

namespace App\Policies;

use App\Models\User;

class BaseContentPolicy
{
    public function viewAny(User $user): bool { return $user->isEditor() || $user->isAdmin(); }
    public function view(User $user): bool { return $user->isEditor() || $user->isAdmin(); }
    public function create(User $user): bool { return $user->isEditor() || $user->isAdmin(); }
    public function update(User $user): bool { return $user->isEditor() || $user->isAdmin(); }
    public function delete(User $user): bool { return $user->isEditor() || $user->isAdmin(); }
}