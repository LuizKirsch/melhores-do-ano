<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Forçar HTTPS quando usando ngrok ou em produção
        if (str_contains(config('app.url'), 'ngrok') || app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
