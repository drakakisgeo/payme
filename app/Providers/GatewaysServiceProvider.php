<?php


namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class GatewaysServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind('Lollypop\Gateways\GatewayMethodInterface', 'Lollypop\Gateways\Braintree');
        $this->app['config']['paymentMethod'] = 'BrainTree';
    }


}