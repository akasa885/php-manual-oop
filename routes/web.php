<?php

use Preps\Components\Routing\Router;

$router = new Router;

$router->get('/', 'IndexController@index');

$router->get('/about', 'IndexController@about');