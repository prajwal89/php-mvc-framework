<?php

namespace App\Core;


class View
{
    protected const VIEWS_BASE_DIR = __DIR__ . "/../views";

    public function __construct(public string $viewName)
    {
    }

    public function renderView()
    {
        $viewPath = self::VIEWS_BASE_DIR . "/$this->viewName.php";

        if (is_file($viewPath)) {
            include_once $viewPath;
        } else {
            exit("{$callback} view file not available");
        }
    }
}
