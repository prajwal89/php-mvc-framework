<?php

namespace App\Core;

use \Dotenv\Dotenv;

class Application
{
    public $request;
    public $response;
    public $router;
    public $session;
    public static $app;

    /**
     * Create Application instance
     */

    function __construct()
    {
        $this->session = new Session();
        $this->request = new Request($this->session);
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        self::$app = $this;
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
