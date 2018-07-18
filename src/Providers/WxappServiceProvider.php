<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use luoyy\Wechat\Wechat;
use luoyy\Wechat\Wxapp;

class MLSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Wxapp::class, function () {
            return new Wxapp();
        });
        $this->app->singleton(Wechat::class, function () {
            return new Wechat();
        });
    }
}
