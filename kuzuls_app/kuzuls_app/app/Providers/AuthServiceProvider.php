<?php

namespace App\Providers;

use App\Models\{Galerija, Jaunums, Kategorija, KontaktZinojums, Lapa, Pasakums, Projekts, SaturaSaite, User};
use App\Policies\{BaseContentPolicy, ContactMessagePolicy, KategorijaPolicy, KontaktZinojumsPolicy, SaturaSaitePolicy, UserPolicy};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Pasakums::class => \App\Policies\BaseContentPolicy::class,
        \App\Models\Projekts::class => \App\Policies\BaseContentPolicy::class,
        \App\Models\Jaunums::class  => \App\Policies\BaseContentPolicy::class,
        \App\Models\Galerija::class => \App\Policies\BaseContentPolicy::class,
        \App\Models\Lapa::class     => \App\Policies\BaseContentPolicy::class,

        \App\Models\Kategorija::class      => \App\Policies\KategorijaPolicy::class,
        \App\Models\KontaktZinojums::class => \App\Policies\KontaktZinojumsPolicy::class,
        \App\Models\SaturaSaite::class     => \App\Policies\SaturaSaitePolicy::class,
        \App\Models\User::class            => \App\Policies\UserPolicy::class,
    ];
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user?->isAdmin()) return true;
            return null;
        });
    }
}