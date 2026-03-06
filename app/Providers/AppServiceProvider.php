<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- 1. IMPORTANTE: Agregar esta línea arriba

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
        // 2. IMPORTANTE: Forzar HTTPS si estamos en el servidor de Render (producción)
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
