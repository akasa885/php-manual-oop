<?php
namespace Preps\Components\Routing;

use Preps\Components\Http\Request;
use Preps\Components\Routing\RouterInterface;

class Router extends Request implements RouterInterface
{
    protected $routes = [];

    protected $request;

    public function __construct()
    {
        $this->request = new Request;
    }

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function put($uri, $action)
    {
        $this->routes['PUT'][$uri] = $action;
    }

    public function patch($uri, $action)
    {
        $this->routes['PATCH'][$uri] = $action;
    }

    public function delete($uri, $action)
    {
        $this->routes['DELETE'][$uri] = $action;
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
    }

    public function dispatch()
    {
        $uri = $this->request->url();
        $method = $this->request->method();
        $action = $this->routes[$method][$uri];
        $this->callAction($action);
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
        $controller->{$action[1]}();
    }

    public function registerControllers($controllerName)
    {
        require_once base_path() . '/app/Http/Controllers/Controller.php';
        
        require_once base_path() . '/app/Http/Controllers/' . $controllerName . '.php';
    }

    public function routes()
    {
        return $this->routes;
    }
}