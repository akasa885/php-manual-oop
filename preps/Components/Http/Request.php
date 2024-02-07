<?php

namespace Preps\Components\Http;

class Request {

    protected $url;

    protected $method;

    protected $headers;

    protected $body;

    protected $query;

    protected $params;

    public function __construct() 
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders();
        $this->body = $_POST;
        $this->query = $_GET;
        $this->params = $_REQUEST;
    }

    public function url() 
    {
        return $this->url;
    }

    public function method() 
    {
        return $this->method;
    }

    public function headers() 
    {
        return $this->headers;
    }

    public function body() 
    {
        return $this->body;
    }

    public function query() 
    {
        return $this->query;
    }

    public function params() 
    {
        return $this->params;
    }

    public function input($key) 
    {
        return $this->params[$key];
    }

    public function has($key) 
    {
        return isset($this->params[$key]);
    }

    public function only($keys): array 
    {
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $this->params[$key];
        }

        return $values;
    }

    public function except($keys): array 
    {
        $values = [];
        foreach ($this->params as $key => $value) {
            if (!in_array($key, $keys)) {
                $values[$key] = $value;
            }
        }

        return $values;
    }

    public function all(): array 
    {
        return $this->params;
    }

    public function __get($name) 
    {
        return $this->params[$name];
    }

    public function __set($name, $value) 
    {
        $this->params[$name] = $value;
    }

    public function __isset($name) 
    {
        return isset($this->params[$name]);
    }

    public function __unset($name) 
    {
        unset($this->params[$name]);
    }

    public function __toString() 
    {
        return json_encode($this->params);
    }

    public function __invoke() 
    {
        return $this->params;
    }

    public function __debugInfo() 
    {
        return $this->params;
    }

    public function __sleep() 
    {
        return ['params'];
    }

    public function __wakeup() 
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders();
        $this->body = $_POST;
        $this->query = $_GET;
    }
}