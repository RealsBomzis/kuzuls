<?php

namespace App\Models\Concerns;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRoles
{
    public function roles(): BelongsToMany
    {
        // Pivot table: role_user
        return $this->belongsToMany(Role::class, 'role_user')->withTimestamps();
    }

    public function hasRole(string $role): bool
    {
        // Column in roles table: nosaukums
        return $this->roles()->where('nosaukums', $role)->exists();
    }

    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('nosaukums', $roles)->exists();
    }
}