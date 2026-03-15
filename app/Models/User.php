<?php

namespace App\Models;

use App\Models\Concerns\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime', // safe even if column doesn't exist
    ];

    /**
     * Convenience: allow policies/middleware to check admin/editor quickly.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isEditor(): bool
    {
        return $this->hasRole('editor');
    }
}