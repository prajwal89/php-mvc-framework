<?php

namespace App\Core;

/**
 * request made by client
 */
class Request
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // get path without query string
        $position = strpos($_SERVER['REQUEST_URI'], '?');

        if (!$position) {
            return $path;
        }

        return substr($_SERVER['REQUEST_URI'], 0, $position);
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}
