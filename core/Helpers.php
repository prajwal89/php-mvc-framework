<?php

if (!function_exists('view')) {
    function view($viewName)
    {
        return new App\Core\View($viewName);
    }
}
