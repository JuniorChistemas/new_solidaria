<?php

namespace App\Providers;
use App\Models\Zone;
use App\Observers\ZoneObserver;

use App\Models\Movement;
use App\Observers\MovementObserver;
use App\Models\Product;
use App\Observers\ProductObserver;

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
        Zone::observe(ZoneObserver::class);
        Movement::observe(MovementObserver::class);
        Product::observe(ProductObserver::class);
    }
}
