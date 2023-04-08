<?php

namespace App\Core;

class Session
{
    private const FLASH = 'flash';

    public const VALIDATION_ERRORS = 'validation_errors';

    public function __construct()
    {
        session_start();
    }

    public function setFlash($key, $value)
    {
        return $_SESSION[self::FLASH][$key] = $value;
    }

    public function getFlash($key)
    {
        if (isset($_SESSION[self::FLASH][$key])) {
            return $_SESSION[self::FLASH][$key];
        } else {
            return false;
        }
    }

    public function hasErrors()
    {
        if (isset($_SESSION[self::FLASH][Session::VALIDATION_ERRORS])) {
            return (count($_SESSION[self::FLASH][Session::VALIDATION_ERRORS]) > 0) ? true : false;
        } else {
            return false;
        }
    }

    public function getErrors(): array
    {
        return $_SESSION[self::FLASH][Session::VALIDATION_ERRORS];
    }

    /**
     * Get a value from the session.
     *
     * @param  string  $key The key to get the value for.
     * @param  mixed  $default The default value to return if the key is not set.
     * @return mixed The value stored in the session, or the default value if the key is not set.
     */
    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Set a value in the session.
     *
     * @param  string  $key The key to set the value for.
     * @param  mixed  $value The value to store in the session.
     * @return void
     */
    public static function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function __destruct()
    {
        // clear all error message
        if (isset($_SESSION[self::FLASH])) {
            unset($_SESSION[self::FLASH]);
        }
    }
}
