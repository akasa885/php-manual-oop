<?php

namespace preps\Components\Foundation;

use preps\Components\Http\Request;
use preps\Components\Routing\Router;
use Preps\Components\Providers\RouteServiceProviders as ServiceProvider;


class App extends Router
{
    protected $param = null;

    protected $params = [];

    protected $appBasePath;

    protected static $instance;

    public function __construct($appPath)
    {
        $this->appBasePath = $appPath;

        $this->request = new Request;

        $providers = new ServiceProvider($this);

        $providers->registerProviders();

        $this->dispatch();

        $this->params = $this->request->params();

        $this->setInstance($this);
        
    }

    public function basepath()
    {
        return $this->appBasePath;
    }

    public function regRoutes(Router $callback)
    {
        $this->routes = $callback->routes;
    }

    public function setInstance($instance)
    {
        $this->instance = $instance;
    }

    public static function getInstance($appPath = null)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static($appPath);
        }

        return static::$instance;
    }

    public function make($abstract, array $parameters = [])
    {
        return new $abstract;
    }
}
