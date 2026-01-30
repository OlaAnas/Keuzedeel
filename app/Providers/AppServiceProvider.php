<?php

namespace App\Providers;

use App\Models\Keuzedeel;
use App\Observers\KeuzedelObserver;
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
        Keuzedeel::observe(KeuzedelObserver::class);
    }
}
