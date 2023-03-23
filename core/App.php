<?php

namespace App\Core;

class Application
{
    public $router;

    /**
     * Create Application instances
     */

    function __construct()
    {
        $this->router = new Router();
    }
}
