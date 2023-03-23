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

            call_user_func($callback);
        } else {
            exit("$method:$path route does not exists");
        }
    }
}
