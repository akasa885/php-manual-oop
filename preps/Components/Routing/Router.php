<?php

namespace Preps\Components\Routing;

use Preps\Components\Http\Request;
use Preps\Components\Routing\RouterInterface;

class Router extends Request implements RouterInterface
{
    protected $routes = [];

    protected $routesNamed = [];

    protected $request;

    private $setUrl;

    public function __construct()
    {
        $this->request = new Request;
    }

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
        $this->setUrl = $uri;

        return $this;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
        $this->setUrl = $uri;

        return $this;
    }

    public function put($uri, $action)
    {
        $this->routes['PUT'][$uri] = $action;
        $this->setUrl = $uri;

        return $this;
    }

    public function patch($uri, $action)
    {
        $this->routes['PATCH'][$uri] = $action;
        $this->setUrl = $uri;

        return $this;
    }

    public function delete($uri, $action)
    {
        $this->routes['DELETE'][$uri] = $action;
        $this->setUrl = $uri;

        return $this;
    }

    public function resource($uri, $controller)
    {
        $this->get($uri, $controller . '@index');
        $this->get($uri . '/create', $controller . '@create');
        $this->post($uri, $controller . '@store');
        $this->get($uri . '/{id}', $controller . '@show');
        $this->get($uri . '/{id}/edit', $controller . '@edit');
        $this->put($uri . '/{id}', $controller . '@update');
        $this->patch($uri . '/{id}', $controller . '@update');
        $this->delete($uri . '/{id}', $controller . '@destroy');

        return $this;
    }

    public function dispatch()
    {
        try {
            $uri = $this->request->url();
            if (strpos($uri, '?') !== false) {
                $uri = explode('?', $uri);
                $uri = $uri[0];
            }

            $method = $this->request->method();
            
            if ($action = $this->routes[$method][$uri]) {
                $this->callAction($action);
                return;
            }

            return view('pages.catch.404');
        } catch (\Throwable $th) {
            throw new \Exception("Route {$uri} not found");
            var_dump ( view('pages.catch.404') );
        }
    }

    protected function callAction($action)
    {
        $action = explode('@', $action);
        $controller = "App\\Http\\Controllers\\{$action[0]}";

        $this->registerControllers($action[0]);

        if (!class_exists($controller)) {
            throw new \Exception("Controller {$controller} not found");
        }

        $controller = new $controller;
        $controller->{$action[1]}($this->request);
    }

    public function registerControllers($controllerName)
    {
        require_once base_path() . '/app/Http/Controllers/Controller.php';

        require_once base_path() . '/app/Http/Controllers/' . $controllerName . '.php';
    }

    public function name($routeName)
    {
        $this->routesNamed[$routeName] = $this->setUrl;

        return $this;
    }

    public function routes()
    {
        return $this->routes;
    }

    public function routesNamed()
    {
        return $this->routesNamed;
    }
}
