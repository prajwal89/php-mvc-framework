<?php

namespace App\Core;

use App\Core\Enums\HttpStatusCode;

class Router
{
    // collet all application routes
    protected $allRoutes = [];
    protected $allowedMethods = ['get', 'post'];
    public $middleware = null;

    public function __construct(public Request $request, public Response $response)
    {
    }

    public function get($path, $callback)
    {
        $this->addRoute('get', $path, $callback);
        return $this;
    }

    public function post($path, $callback)
    {
        $this->addRoute('post', $path, $callback);
        return $this;
    }

    public function addRoute(string $method, string $path, $callback)
    {
        $pathPattern = preg_replace('/\{([a-zA-Z0-9_-]+)\}/', '([a-zA-Z0-9_-]+)', $path);
        $pathPattern = str_replace('/', '\/', $pathPattern);

        $this->allRoutes[$method][] = [
            'original_path' => $path,
            'is_dynamic' => preg_match('/\{([a-zA-Z0-9_-]+)\}/', $path),
            'pattern' =>  $pathPattern,
            'callback' =>  $callback,
            'middleware' =>  $this->middleware,
        ];

        $this->middleware = null;
    }

    public function match($methods, $path, $callback)
    {
        $diff = array_diff($methods, $this->allowedMethods);
        if (empty($diff)) {
            foreach ($methods as $method) {
                $this->{$method}($path, $callback);
            }
        } else {
            exit('In valid method in match function');
        }
    }


    public function middleware($middleware)
    {
        $middlewareRegistry = include(dirname(__DIR__) . '/middlewares/Registry.php');
        if (!in_array($middleware, array_keys($middlewareRegistry))) {
            exit("Middleware {$middleware} is not registered");
        }
        $this->middleware = $middlewareRegistry[$middleware];
        return $this;
    }

    //handle current request
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        foreach ($this->allRoutes[$method] as $route) {
            $pattern = $route['pattern'];
            $callback = $route['callback'];
            $middleware = $route['middleware'];

            // check if current client request exists
            if (preg_match("#^$pattern$#", $path, $matches)) {

                // handle middleware if present
                if (!is_null($middleware)) {
                    // execute middleware
                    $controller = new $middleware;
                    if (!$controller->handle()) {
                        return $this->response->status(HttpStatusCode::UNAUTHORIZED);
                    }
                }

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
                    return call_user_func($callback);
                }

                return $this->response->status(HttpStatusCode::BAD_REQUEST);
            }
        }

        return $this->response->status(HttpStatusCode::NOT_FOUND);
    }
}
