<?php

if (!function_exists('view')) {
    function view($viewName)
    {
        return new App\Core\View($viewName);
    }
}

if (!function_exists('session')) {
    function session()
    {
        return App\Core\Application::$app->session;
    }
}

if (!function_exists('redirect')) {
    function redirect($path)
    {
        return App\Core\Application::$app->response->redirect($path);
    }
}
