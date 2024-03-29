<?php

namespace Preps\Components\Routing;

interface RouterInterface
{
    public function get($uri, $action);

    public function post($uri, $action);

    public function put($uri, $action);

    public function patch($uri, $action);

    public function delete($uri, $action);

    public function resource($uri, $controller);
}