<?php

namespace App\Providers;

use App\Online_exam\Sign_in\Contracts\Signin;
use App\Online_exam\Sign_in\Third_party\Facebook;
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
        $this->app->bind(Signin::class, function ($app) {
            return new Facebook();
        });
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
