<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        Validator::extend('no_special_chars', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/', $value);
        });
        Validator::extend('not_negative', function($attribute, $value, $parameters, $validator) {
            return $value >= 0;
        });
        Validator::extend('greater_than_zero', function($attribute, $value, $parameters, $validator) {
            return $value > 0;
        });
    }
}
