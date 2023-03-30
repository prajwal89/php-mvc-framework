<?php

namespace App\Core;

class Database
{

    private static $conn;

    public static function connection()
    {
        if (!self::$conn) {
            try {
                self::$conn = new  \PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'] . "", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
                self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        return self::$conn;
    }

    // Prevent cloning of the object
    private function __clone()
    {
    }
}
