<?php

namespace App\Providers;

use App\User;
use Curl\Curl;
use Illuminate\Support\ServiceProvider;
use Lollypop\Services\Clef;

class ClefServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('clef', function () {

            $auth = app()->make('auth');
            $session = app()->make('session.store');
            return new Clef(new User, $auth, $session,new Curl());

        });

        $this->app->bind('Lollypop\Services\Clef',function(){
           return $this->app->make('clef');
        });

    }
}
