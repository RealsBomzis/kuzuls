<?php

namespace App\Providers;

use App\Models\{Galerija, Jaunums, Lapa, Pasakums, Projekts};
use App\Observers\ContentObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Pasakums::observe(ContentObserver::class);
        Projekts::observe(ContentObserver::class);
        Jaunums::observe(ContentObserver::class);
        Galerija::observe(ContentObserver::class);
        Lapa::observe(ContentObserver::class);
    }
}
