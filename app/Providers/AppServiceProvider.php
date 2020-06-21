<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;

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
        Validator::extend('name', function($attribute, $value)
        {
            return preg_match('/^[a-z\sÑñ.,-]+$/i', $value);
        });

        Validator::extend('alpha_space', function($attribute, $value)
        {
            /*
                Customized the regex pattern to satisfy these needs/limitations
                1. Some names has the character Ñ or ñ so I placed this characters in the pattern.
                2. The previous \pL matches any character from any language.
                   This is not acceptable because users may enter undesirable character.
                   To solve this problem, I change it to a-z and set the regex option to i
            */
            return preg_match('/^[a-z\sÑñ]+$/i', $value);
        });

        Validator::extend('alpha_num_space', function($attribute, $value)
        {
            /*
                Same as the one above except that Ñ or ñ is not acceptable and support for numbers is included.
            */
            return preg_match('/^[a-z0-9\s-]+$/i', $value);
        });

        Paginator::defaultView('vendor.pagination.semantic-ui');
    }
}
