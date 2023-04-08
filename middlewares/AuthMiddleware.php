<?php

namespace App\Middlewares;

use App\Core\Abstract\Middleware;

class AuthMiddleware extends Middleware
{
    public function handle()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }

        return false;
    }
}
