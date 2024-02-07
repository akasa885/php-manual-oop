<?php

namespace App\Providers;

use Preps\Components\Providers\RouteServiceProviders as ServiceProvider;

class RouteProviders extends ServiceProvider
{

    public function boot()
    {
        require $this->app->basepath() . '/routes/web.php';


        $this->app->regRoutes($router);
    }
}