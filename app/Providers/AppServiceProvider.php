<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \App\Services\CopyAndPay;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('CopyAndPay\InitCheckout', CopyAndPay\InitCheckout::class);
        $this->app->singleton('CopyAndPay\PaymentStatus', CopyAndPay\PaymentStatus::class);
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
