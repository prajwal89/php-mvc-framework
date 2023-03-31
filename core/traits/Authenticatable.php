<?php

namespace App\Core\Traits;

trait Authenticatable
{
    public static function attempt(array $dbFields)
    {
        if ($user = (new static())::find($dbFields)) {
            return $user;
        } else {
            return false;
        }
    }

    public static function login()
    {
    }
}
