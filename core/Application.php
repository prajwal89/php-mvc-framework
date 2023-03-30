<?php

namespace App\Core;

use \Dotenv\Dotenv;

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
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
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
