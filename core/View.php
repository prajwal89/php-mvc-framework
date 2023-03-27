<?php

namespace App\Core;


class View
{
    protected const VIEWS_BASE_DIR = __DIR__ . "/../views";
    public $viewData = [];
    public $viewPath;
    public $layoutName = null;

    public function __construct(public string $viewName)
    {
        $this->viewPath = self::VIEWS_BASE_DIR . "/$this->viewName.php";

        // support for dot notation for view names
        if (str_contains($this->viewName, '.')) {
            $pathFromString = '/' . str_replace('.', '/', $this->viewName);
            $this->viewPath = self::VIEWS_BASE_DIR . "/$pathFromString.php";
        }
    }

    public function with($key, $value)
    {
        $this->viewData[$key] = $value;
        return $this;
    }

    public function layout($layoutName)
    {
        $this->layoutName = $layoutName;
        return $this;
    }

    public function getLayoutContent(): ?string
    {
        $pathFromString = '/' . str_replace('.', '/', $this->layoutName);
        $layoutPath = self::VIEWS_BASE_DIR . "$pathFromString.php";

        ob_start();
        include_once($layoutPath);
        return ob_get_clean();
    }

    public function getViewContents()
    {
        ob_start();
        include_once($this->viewPath);
        return ob_get_clean();
    }

    public function render()
    {
        if (is_file($this->viewPath)) {
            if (empty($this->layoutName)) {
                include_once $this->viewPath;
            } else {
                // render view with layout
                return str_replace('@content', $this->getViewContents(), $this->getLayoutContent());
            }
        } else {
            exit("{$this->viewName} view file not available");
        }
    }
}
