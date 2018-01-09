<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Events\Dispatcher;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        /**
         * Validate two fields value are same
         * 
         * @parameters[0], password value
         * @return bool
         */
        Validator::extend('confirmationPassword', function ($attribute, $value, $parameters, $validator) {            
            return $value === $parameters[0];
        });
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
