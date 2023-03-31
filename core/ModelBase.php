<?php

namespace App\Core;

use App\Core\Database;

class ModelBase
{
    protected $data = [];

    // insert record and return model instance
    public static function create(array $values)
    {
        // get child model
        $model = new static();

        $diff = array_diff(array_keys($values), $model->fillable);

        if (count($diff) > 0) {
            exit($diff[0] . ' cannot be inserted b.c it is not fillable');
        }

        $sql = "INSERT INTO `$model->table` (" . implode(",", array_keys($values)) . ") VALUES (:" . implode(",:", array_keys($values)) . ")";

        $stmt = Database::connection()->prepare($sql);

        foreach ($values as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        // assign dynamic properties to child model
        if ($stmt->execute()) {
            $lastInsertId = Database::connection()->lastInsertId();
            $query = "SELECT * FROM `$model->table` WHERE id=:id";
            $stmt = Database::connection()->prepare($query);
            $stmt->bindValue(':id', $lastInsertId);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            foreach ($result as $key => $value) {
                $model->{$key} = $value;
            }
        }

        return $model;
    }

    // update record and return boolean
    public static function update($id, array $values): bool
    {
        // get child model
        $model = new static();

        $setValues = [];
        foreach ($values as $key => $value) {
            $setValues[] = "$key = :$key";
        }
        $sql = "UPDATE " . $model->table . " SET " . implode(",", $setValues) . " WHERE id=:id";

        $stmt = Database::connection()->prepare($sql);

        foreach ($values as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    }

    // delete record and return boolean
    public static function delete($id): bool
    {
        $model = new static();

        $sql = "DELETE FROM " . $model->table . " WHERE id=:id";

        $stmt = Database::connection()->prepare($sql);

        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    }

    public static function all()
    {
        $model = new static();
        $query = "SELECT * FROM " . $model->table;
        $stmt = Database::connection()->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $models = [];

        foreach ($results as $result) {
            $model = new static();
            foreach ($result as $key => $value) {
                $model->{$key} = $value;
            }
            $models[] = $model;
        }

        return $models;
    }

    public static function find(array $values)
    {
        $model = new static();
        $query = "SELECT * FROM " . $model->table . " WHERE ";

        $conditions = [];
        foreach ($values as $key => $value) {
            $conditions[] = "{$key} = :{$key}";
        }
        $query .= implode(' AND ', $conditions) . " LIMIT 1";

        $stmt = Database::connection()->prepare($query);
        foreach ($values as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        foreach ($result as $key => $value) {
            $model->{$key} = $value;
        }

        return $model;
    }


    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }
}
