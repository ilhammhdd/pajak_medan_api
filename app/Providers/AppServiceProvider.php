<?php

namespace App\Providers;

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
        Schema::defaultStringLength(191);
//        $this->app->singleton('Illuminate\Contracts\Routing\ResponseFactory', function ($app) {
//            return new \Illuminate\Routing\ResponseFactory(
//                $app['Illuminate\Contracts\View\Factory'],
//                $app['Illuminate\Routing\Redirector']
//            );
//        });
    }
}
