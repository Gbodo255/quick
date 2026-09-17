<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // L'interface (front public + admin) est entièrement en français,
        // indépendamment de APP_LOCALE (utilisé pour les messages de validation).
        Carbon::setLocale('fr');
    }
}
