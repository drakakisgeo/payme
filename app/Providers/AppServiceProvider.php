<?php

    namespace App\Providers;

    use Braintree_Configuration;
    use Illuminate\Support\ServiceProvider;

    class AppServiceProvider extends ServiceProvider
    {
        /**
         * Bootstrap any application services.
         *
         * @return void
         */
        public function boot()
        {
            Braintree_Configuration::environment(
              getenv('BRAINTREE_ENVIRONMENT')
            );

            Braintree_Configuration::merchantId(
              getenv('BRAINTREE_MERCHANTID')
            );
            Braintree_Configuration::publicKey(
              getenv('BRAINTREE_PUBLICKEY')
            );
            Braintree_Configuration::privateKey(
              getenv('BRAINTREE_PRIVATEKEY')
            );
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
