<?php

namespace App\Core;


class View
{
    protected const VIEWS_BASE_DIR = __DIR__ . "/../views";
    public $viewData = [];

    public function __construct(public string $viewName)
    {
    }

    public function with($key, $value)
    {
        $this->viewData[$key] = $value;
        return $this;
    }

    public function render()
    {
        $viewPath = self::VIEWS_BASE_DIR . "/$this->viewName.php";

        if (is_file($viewPath)) {
            include_once $viewPath;
        } else {
            exit("{$this->viewName} view file not available");
        }
    }
}
