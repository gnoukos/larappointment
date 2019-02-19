<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extendImplicit('this_or_that', function ($attribute, $value, $parameters, $validator) {
            return (bool) (!empty($value) ^ (array_key_exists($parameters[0], $validator->getData()) && !empty($validator->getData()[$parameters[0]])));
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
