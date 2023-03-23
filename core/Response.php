<?php

namespace App\Core;

class Response
{
    public function status($code)
    {
        http_response_code($code);
    }
}
