<?php

namespace App\Providers;

use App\Services\BasketService;
use Illuminate\Support\ServiceProvider;

class BasketServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BasketService::class, function(){
            return new BasketService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
