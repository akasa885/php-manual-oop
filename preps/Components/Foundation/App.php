<?php

namespace preps\Components\Foundation;

use preps\Components\Http\Request;
use preps\Components\Routing\Router;
use Preps\Components\Providers\RouteServiceProviders as ServiceProvider;


class App extends Router
{

    protected $controller = 'IndexController';

    protected $method = 'index';

    protected $param = null;

    protected $params = [];

    protected $appBasePath;

    public function __construct($appPath)
    {
        $this->appBasePath = $appPath;

        $this->request = new Request;

        $providers = new ServiceProvider($this);

        $providers->registerProviders();

        // roiuer dispatch will be called from here, return the response and send it to the browser
        return $this->dispatch();
    }

    public function basepath()
    {
        return $this->appBasePath;
    }

    public function regRoutes(Router $callback)
    {
        $this->routes = $callback->routes;
    }

    public function bind($controller, $method, $param)
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->param = $param;
    }

    public function run()
    {
        $this->controller = new $this->controller;
        if ($this->param) {
            call_user_func_array([$this->controller, $this->method], [$this->param]);
        } else {
            if (!empty($this->params)) {
                call_user_func_array([$this->controller, $this->method], $this->params);
            } else {
                call_user_func([$this->controller, $this->method]);
            }
        }
    }
}
