<?php

namespace App\Core;

use App\Core\Enums\HttpStatusCode;

class Router
{
    // collet all application routes
    protected $allRoutes = [];

    public function __construct(public Request $request, public Response $response)
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

            //render view file from string
            if (is_string($callback)) {
                return view($callback)->render();
            }

            if (is_array($callback)) {
                // create an instance of the ContactController class
                $controller = new $callback[0];

                // call the getPage method on the controller instance
                return $controller->{$callback[1]}();
            }

            if (is_callable($callback)) {
                return call_user_func($callback);
            }

            return $this->response->status(HttpStatusCode::BAD_REQUEST);
        }

        return $this->response->status(HttpStatusCode::NOT_FOUND);
    }
}
