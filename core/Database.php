<?php

namespace App\Core;

class Database
{
    private static $conn;

    public static function connection()
    {
        if (!self::$conn) {
            try {
                self::$conn = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'] . '', $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
                self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }

        return self::$conn;
    }

    public static function query($query, $bindings = [])
    {
        $stmt = self::connection()->prepare($query);
        $result = $stmt->execute($bindings);
        if ($result === false) {
            return false;
        }
        if (stripos($query, 'SELECT') === 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } elseif (stripos($query, 'INSERT') === 0) {
            return self::connection()->lastInsertId();
        } else {
            return $stmt->rowCount();
        }
    }

    public static function select($query, $bindings = []): array
    {
        $stmt = self::connection()->prepare($query);
        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function update($query, $bindings = []): int
    {
        $stmt = self::connection()->prepare($query);
        $stmt->execute($bindings);

        return $stmt->rowCount();
    }

    public static function delete($query, $bindings = []): int
    {
        $stmt = self::connection()->prepare($query);
        $stmt->execute($bindings);

        return $stmt->rowCount();
    }

    public static function create($query, $bindings = []): int
    {
        $stmt = self::connection()->prepare($query);
        $stmt->execute($bindings);

        return $stmt->rowCount();
    }

    // Prevent cloning of the object
    private function __clone()
    {
    }
}
