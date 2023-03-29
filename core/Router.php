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
        $pathPattern = preg_replace('/\{([a-zA-Z0-9_-]+)\}/', '([a-zA-Z0-9_-]+)', $path);
        $pathPattern = str_replace('/', '\/', $pathPattern);

        $this->allRoutes['get'][] = [
            'original_path' => $path,
            'is_dynamic' => preg_match('/\{([a-zA-Z0-9_-]+)\}/', $path),
            'pattern' =>  $pathPattern,
            'callback' =>  $callback,
        ];
    }

    public function post($path, $callback)
    {
        $pathPattern = preg_replace('/\{([a-zA-Z0-9_-]+)\}/', '([a-zA-Z0-9_-]+)', $path);
        $pathPattern = str_replace('/', '\/', $pathPattern);

        $this->allRoutes['post'][] = [
            'original_path' => $path,
            'is_dynamic' => preg_match('/\{([a-zA-Z0-9_-]+)\}/', $path),
            'pattern' =>  $pathPattern,
            'callback' =>  $callback,
        ];
    }

    //handle current request
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        foreach ($this->allRoutes[$method] as $route) {
            $pattern = $route['pattern'];
            $callback = $route['callback'];

            // check if current client request exists
            if (preg_match("#^$pattern$#", $path, $matches)) {
                // remove the first element from $matches, which is the entire matched string
                array_shift($matches);

                if (is_string($callback)) {
                    return view($callback, $matches)->render();
                }

                if (is_array($callback)) {
                    $controller = new $callback[0];
                    return $controller->{$callback[1]}($this->request, ...$matches);
                }

                if (is_callable($callback)) {
                    return call_user_func_array($callback, array_merge([$this->request], $matches));
                }

                return $this->response->status(HttpStatusCode::BAD_REQUEST);
            }
        }

        return $this->response->status(HttpStatusCode::NOT_FOUND);
    }
}
