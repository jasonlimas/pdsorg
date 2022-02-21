<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        // Check if user is admin
        Blade::if('admin', function () {
            if (auth()->check()) return auth()->user()->role_id == 1;
        });

        // Check if user is team leader
        Blade::if('teamleader', function () {
            if (auth()->check()) return auth()->user()->role_id == 2;
        });

        // Check if user is sales person
        Blade::if('salesperson', function () {
            if (auth()->check()) return auth()->user()->role_id == 3;
        });
    }
}
