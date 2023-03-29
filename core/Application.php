<?php

namespace App\Core;

class Application
{
    public $request;
    public $response;
    public $router;

    /**
     * Create Application instances
     */
    function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run(): void
    {
        echo $this->router->resolve();
    }

    public function runInConsole()
    {
        (new Console($_SERVER['argv']))->resolve();
    }
}
