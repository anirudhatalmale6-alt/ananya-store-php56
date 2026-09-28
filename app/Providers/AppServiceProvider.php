<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // MySQL versions shipped alongside PHP 5.6 (5.5 / 5.6) cap an index
        // key at 767 bytes, which is 191 utf8mb4 characters. Laravel 5.4's
        // default string length of 255 overflows that on unique columns.
        Schema::defaultStringLength(191);

        View::composer('layouts.store', 'App\View\Composers\StoreComposer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
