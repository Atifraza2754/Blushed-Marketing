<?php

namespace App\Providers;

use App\Models\defaultRates;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('flatRate', function () {
            return defaultRates::where('is_active' , 1)->first()->flat_rate ?? 0;  // Assuming the flat_rate is static or rarely changed
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
