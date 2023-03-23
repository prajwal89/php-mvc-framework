<?php

namespace App\Core;


class Router
{
    // collet all application routes
    protected $allRoutes = [];

    public function __construct(public Request $request)
    {
    }

    public function get($path, $callback)
    {
        $this->allRoutes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->allRoutes['post'][$path] = $callback;
    }

    //handle current request
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        //check if current client request exists
        if (isset($this->allRoutes[$method][$path])) {
            $callback = $this->allRoutes[$method][$path];

            if (is_string($callback)) {
                //todo render view
                return (new View($callback))->renderView();
            }

            if (is_array($callback)) {
                //todo invoke controller method
                return $callback;
            }

            if (is_callable($callback)) {
                return call_user_func($callback);
            }

            return "invalid Callback";
        } else {
            exit("$method:$path route does not exists");
        }
    }

    // public function renderView(string $callback)
    // {
    //     $viewPath = __DIR__ . "/../views/$callback.php";

    //     if (is_file($viewPath)) {
    //         include_once $viewPath;
    //     } else {
    //         exit("{$callback} view file not available");
    //     }
    // }
}
