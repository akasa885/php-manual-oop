<?php

if (!function_exists('env')) {
    /**
     * Get the value of an environment variable.
     *
     * @param string $key
     * @
     * @return mixed
     */
    function env($key, $default = null)
    {
        // get the file .env path
        $dotenv = base_path('/.env');
        // check if the file exists
        if (file_exists($dotenv)) {
            // read the file
            $lines = file($dotenv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            // loop through the lines
            foreach ($lines as $line) {
                // check if the line is not a comment
                if (strpos(trim($line), '#') !== 0) {
                    // split the line by the equal sign
                    list($envKey, $envValue) = explode('=', $line, 2);

                    // check if the key matches the key we are looking for
                    if ($envKey === $key) {
                        return $envValue;
                    }
                }
            }
        }

        return $default;
    }
}

if (!function_exists('config')) {
    /**
     * Get the value of a configuration variable.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function config($key, $default = null)
    {
        $keys = explode('.', $key);
        $config = require __DIR__ . '/config/' . $keys[0] . '.php';
        foreach ($keys as $key) {
            if ($key === $keys[0]) {
                continue;
            }
            $config = $config[$key];
        }
        return $config;
    }
}

if (!function_exists('abort')) {
    /**
     * Abort the application.
     *
     * @param int $code
     * @return void
     */
    function abort($code, $message = null)
    {
        http_response_code($code);
        if (is_null($message)) {
            $message = match ($code) {
                404 => 'Not Found',
                500 => 'Internal Server Error',
                default => 'Something went wrong',
            };
        }

        exit($message);
    }
}

if (!function_exists('app')) {
    /**
     * Get the application instance.
     *
     * @return \preps\Components\Foundation\App
     */
    function app($abstract = null, array $parameters = [])
    {
        return \preps\Components\Foundation\App::getInstance();
        // if (is_null($abstract)) {
        //     return \preps\Components\Foundation\App::getInstance();
        // }
        // return \preps\Components\Foundation\App::getInstance()->make($abstract, $parameters);
    }
}

if (!function_exists('base_path')) {
    /**
     * Get the base path of the application.
     *
     * @param string $path
     * @return string
     */
    function base_path($path = '')
    {
        return $_SERVER['DOCUMENT_ROOT'] . $path;
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the public path of the application.
     *
     * @param string $path
     * @return string
     */
    function public_path($path = '')
    {
        return base_path('/public' . $path);
    }
}

if (!function_exists('view')) {
    /**
     * Render a view.
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    function view($view, $data = [])
    {
        $view = '/' . trim($view, '/');
        $view = str_replace('.', '/', $view) . '.php';
        $view = new \preps\Components\Foundation\View(base_path($view), $data);
        $view->render();
    }
}

if (!function_exists('compact')) {
    /**
     * Create an array from variables and their values.
     *
     * @param mixed $vars
     * @return array
     */
    function compact(...$vars)
    {
        $data = [];
        foreach ($vars as $var) {
            $data[$var] = $$var;
        }
        return $data;
    }
}

if (!function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @return string
     */
    function asset($path)
    {
        try {
            return rtrim(APP_URL, '/') . '/' . ltrim($path, '/');
        } catch (\Throwable $th) {
            abort(404, 'not found');
        }
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to a given path.
     *
     * @param string $path
     * @return void
     */
    function redirect($path)
    {
        header('Location: ' . $path);
    }
}

if (!function_exists('request')) {
    /**
     * Get the request instance.
     *
     * @return \preps\Components\Http\Request
     */
    function request()
    {
        return new \preps\Components\Http\Request;
    }
}

if (!function_exists('route')) {
    /**
     * Generate a URL for the given route.
     *
     * @param string $name
     * @return string
     */
    function route($name)
    {
        $routes = app()->router->routesNamed();

        return $routes[$name];
    }
}


