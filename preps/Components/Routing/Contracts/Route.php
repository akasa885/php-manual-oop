<?php

namespace Preps\Components\Routing\Contracts;

use Preps\Components\Routing\Router;

trait Route {

    public static function get($uri, $action) {
        return (new Router)->get($uri, $action);
    }

    public static function post($uri, $action) {
        return (new Router)->post($uri, $action);
    }

    public static function put($uri, $action) {
        return (new Router)->put($uri, $action);
    }

    public static function patch($uri, $action) {
        return (new Router)->patch($uri, $action);
    }

    public static function delete($uri, $action) {
        return (new Router)->delete($uri, $action);
    }

    public static function resource($uri, $controller) {
        return (new Router)->resource($uri, $controller);
    }
}