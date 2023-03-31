<?php

namespace App\Core;


class Session
{
    private const ERROR_BAG_KEY = 'error_bag';
    public const VALIDATION_ERRORS = 'validation_errors';

    public function __construct()
    {
        session_start();
    }

    public function setFlash($key, $value)
    {
        return $_SESSION[self::ERROR_BAG_KEY][$key] = $value;
    }

    public function getFlash($key)
    {
        if (isset($_SESSION[self::ERROR_BAG_KEY][$key])) {
            return $_SESSION[self::ERROR_BAG_KEY][$key];
        } else {
            return false;
        }
    }

    public function hasErrors()
    {
        if (isset($_SESSION[self::ERROR_BAG_KEY][Session::VALIDATION_ERRORS])) {
            return (count($_SESSION[self::ERROR_BAG_KEY][Session::VALIDATION_ERRORS]) > 0) ? true : false;
        } else {
            return false;
        }
    }

    public function getErrors(): array
    {
        return $_SESSION[self::ERROR_BAG_KEY][Session::VALIDATION_ERRORS];
    }

    public function __destruct()
    {
        // clear all error message
        if (isset($_SESSION[self::ERROR_BAG_KEY])) {
            unset($_SESSION[self::ERROR_BAG_KEY]);
        }
    }
}
