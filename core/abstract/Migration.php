<?php

namespace App\Core\Abstract;

use App\Core\Database;

abstract class Migration
{
    public function run(string $sql)
    {
        try {
            Database::connection()->exec($sql);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }

        //todo find efficient way 
        $backtrace = debug_backtrace();
        $caller = isset($backtrace[1]['function']) ? $backtrace[1]['function'] : 'unknown';
        $migrationName = basename(get_called_class());

        if ($caller == 'up') {
            //record migration
            $sql = "INSERT INTO migrations (migration) VALUES ('$migrationName')";
            Database::connection()->exec($sql);
        }

        if ($caller == 'down') {
            //remove migration record
            Database::connection()->exec("DELETE FROM migrations WHERE migration = '$migrationName'");
        }

        if ($caller == 'unknown') {
            exit('This method should be only called from migration file');
        }
    }
}
