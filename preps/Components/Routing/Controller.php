<?php

namespace Preps\Components\Routing;

use Preps\Components\Http\Request;

abstract class Controller
{
    protected $request;

    public function __call($method, $args)
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $args);
        }
    }
}