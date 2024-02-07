<?php

namespace Preps\Components\Providers;

class RouteServiceProviders
{
    protected $app;


    public function __construct($app)
    {
        $this->app = $app;
    }

    public function registerProviders()
    {
        // get config/provders.php. that will return an array of providers
        $providers = require_once $this->app->basepath() . '/config/providers.php';

        // loop through the providers array

        foreach ($providers as $provider) {
            require_once $this->app->basepath() . '/' . $provider . '.php';

            $provider = new $provider($this->app);

            $provider->boot();
        }

        return $this;
    }
}