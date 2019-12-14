<?php

namespace App\Providers;

use App\Inventory;
use App\Observers\InventoryObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Model observers
        Inventory::observe(InventoryObserver::class);
    }
}
