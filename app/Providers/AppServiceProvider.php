<?php

namespace App\Providers;

use App\Models\Complain;
use App\Observers\ComplainObserver;
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
        Complain::observe(ComplainObserver::class);
    }
}
