<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- 1. Tambah baris ini biar rapi

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
        Paginator::useBootstrap(); // (Opsional: Biasanya ini ada kalau pakai pagination bootstrap)

        // 2. Logika yang lebih aman:
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
