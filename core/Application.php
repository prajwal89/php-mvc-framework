<?php

namespace App\Core;

class Application
{
    public $request;
    public $router;

    /**
     * Create Application instances
     */
    function __construct()
    {
        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    public function run()
    {
        $this->router->resolve();
    }
}
