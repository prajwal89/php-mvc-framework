<?php

namespace App\Core;

use App\Core\Enums\HttpStatusCode;

class Response
{
    public function status(HttpStatusCode $code)
    {
        http_response_code($code->value);

        return $code->getText();
    }

    public function redirect($path)
    {
        header("Location: $path");
    }
}
