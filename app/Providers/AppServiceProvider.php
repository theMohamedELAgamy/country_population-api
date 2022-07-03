<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use  App\Repository\iCountryRepository;
use  App\Repository\CountryRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(iCountryRepository::class, CountryRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
