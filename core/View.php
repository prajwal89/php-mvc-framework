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

        // support for . notation fo view names
        if (str_contains($this->viewName, '.')) {
            $pathFromString = '/' . str_replace('.', '/', $this->viewName);
            $viewPath = self::VIEWS_BASE_DIR . "/$pathFromString.php";
        }

        if (is_file($viewPath)) {
            include_once $viewPath;
        } else {
            exit("{$this->viewName} view file not available");
        }
    }
}
