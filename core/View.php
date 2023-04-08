<?php

namespace App\Core;

class View
{
    protected const VIEWS_BASE_DIR = __DIR__ . '/../views';

    public $viewData = [];

    public $viewPath;

    public $layoutName = null;

    public function __construct(public string $viewName)
    {
        $this->viewPath = self::VIEWS_BASE_DIR . "/$this->viewName.view.php";

        // support for dot notation for view names
        if (str_contains($this->viewName, '.')) {
            $pathFromString = '/' . str_replace('.', '/', $this->viewName);
            $this->viewPath = self::VIEWS_BASE_DIR . "$pathFromString.view.php";
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
        $layoutPath = self::VIEWS_BASE_DIR . "/$pathFromString.view.php";

        if (!is_file($layoutPath)) {
            exit("{$this->layoutName} layout not found");
        }

        ob_start();
        include_once $layoutPath;

        return ob_get_clean();
    }

    public function getViewContents()
    {
        ob_start();
        include_once $this->viewPath;

        return ob_get_clean();
    }

    public function render(): string
    {
        $viewContents = $this->getViewContents();

        if (is_file($this->viewPath)) {
            if (empty($this->layoutName)) {
                return $viewContents;
            } else {
                // render view with layout
                $layoutContent = $this->getLayoutContent();
                preg_match_all('/\@yield\s*\(\s*[\'"](.*)[\'"]\s*\)/', $layoutContent, $yieldMatches, PREG_SET_ORDER);

                if (!isset($yieldMatches[0])) {
                    exit("{$this->layoutName} layout has no yield blocks");
                }

                $layoutWithHydratedSectionsContent = $layoutContent;
                foreach ($yieldMatches as $yieldMatch) {
                    //check if view has correct @section block
                    if (preg_match("/\@section\(\'" . $yieldMatch[1] . "\'\)(.*?)\@stop/s", $viewContents, $contentMatches)) {
                        // echo $yieldMatch[1] . PHP_EOL;
                        // echo $yieldMatch[1] . ' found in both layout and view';
                        $sectionContent = $contentMatches[1];
                        $layoutWithHydratedSectionsContent = preg_replace("/\@yield\s*\(\s*[\'\"]" . $yieldMatch[1] . "[\'\"]\s*\)/", $sectionContent, $layoutWithHydratedSectionsContent);

                        //remove section block tags
                    }
                }

                // remove unused yield blocks
                $layoutWithHydratedSectionsContent = preg_replace('/\@yield\s*\(\s*[\'"](.*)[\'"]\s*\)/', '', $layoutWithHydratedSectionsContent);

                return $layoutWithHydratedSectionsContent;
            }
        } else {
            exit("{$this->viewName} view not found");
        }
    }
}
