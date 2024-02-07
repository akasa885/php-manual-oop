<?php

use Preps\Components\Routing\Router;

$router = new Router;

$router->get('/', 'IndexController@index')->name('home');

$router->get('/about', 'IndexController@about');