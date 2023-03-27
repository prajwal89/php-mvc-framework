<?php

namespace App\Core;

/**
 * handle request made by client
 */
class Request
{
    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // get path without query string
        $position = strpos($_SERVER['REQUEST_URI'], '?');

        if (!$position) {
            return $path;
        }

        return substr($_SERVER['REQUEST_URI'], 0, $position);
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}
