<?php

namespace App\Core;

use App\Core\Traits\CliMessage;
use Symfony\Component\VarDumper\Cloner\Data;

class Console
{
    use CliMessage;

    public const START = 'artisan';

    public function __construct(public array $args)
    {
    }

    public function resolve()
    {
        if (!isset($this->args[1])) {
            exit($this->error('No arguments'));
        }

        if ($this->args[1] == 'start') {
            shell_exec('php -S localhost:1234 -t "./public"');
        }

        if ($this->args[1] == 'make:controller') {
            if (!isset($this->args[2])) {
                exit($this->error('Controller name not specified'));
            }
            return $this->makeController($this->args[2]);
        }

        if ($this->args[1] == 'make:model') {
            if (!isset($this->args[2])) {
                exit($this->error('Model name not specified'));
            }
            return $this->makeModel($this->args[2]);
        }

        if ($this->args[1] == 'migrate') {
            return $this->runMigrations();
        }

        $this->error('Command not available');
    }

    private function makeController($controllerFullName)
    {
        $this->info('Creating controller ' . $controllerFullName);
        $stubPath = realpath(__DIR__ . '/stubs/Controller.stub');
        $this->info('Using stub file -> ' . $stubPath);
        $stubContent = file_get_contents($stubPath);

        $controllerClassName = $this->getClassName($controllerFullName);
        $controllerNamespace = $this->getNamespaceName($controllerFullName, 'App\Controllers');

        // replace placeholders
        $controllerFileContent = str_replace('[controllerName]', $controllerClassName, $stubContent);
        $controllerFileContent = str_replace('[namespace]', $controllerNamespace, $controllerFileContent);

        $basePath = realpath(__DIR__ . '/../controllers');

        if (str_contains($controllerFullName, '/')) {
            $filePath = realpath(__DIR__ . '/../controllers') . '/' . $controllerFullName . '.php';
            $parts = explode('/', $controllerFullName);
            array_pop($parts);
            $dir = $basePath . '/' . implode('/', $parts);
            if (!is_dir($dir)) {
                //make directories recursively
                mkdir($dir, 0777, true);
            }
        } else {
            $filePath = realpath(__DIR__ . '/../controllers') . '/' . $controllerClassName . '.php';
        }

        if (is_file($filePath)) {
            return $this->error("Controller Already Exists ->" . $filePath);
        }

        if (@file_put_contents($filePath, $controllerFileContent)) {
            $this->success("Controller Created ->" . $filePath);
        } else {
            $this->error('Invalid controller name');
        }
    }

    private function makeModel($modelFullName)
    {
        $this->info('Creating controller ' . $modelFullName);
        $stubPath = realpath(__DIR__ . '/stubs/Model.stub');
        $this->info('Using stub file -> ' . $stubPath);
        $stubContent = file_get_contents($stubPath);

        $modelClassName = $this->getClassName($modelFullName);
        $modelNamespace = $this->getNamespaceName($modelFullName, 'App\Models');

        // replace placeholders
        $modelFileContent = str_replace('[modelName]', $modelClassName, $stubContent);
        $modelFileContent = str_replace('[namespace]', $modelNamespace, $modelFileContent);

        $basePath = realpath(__DIR__ . '/../models');

        if (str_contains($modelFullName, '/')) {
            $filePath = realpath(__DIR__ . '/../models') . '/' . $modelFullName . '.php';
            $parts = explode('/', $modelFullName);
            array_pop($parts);
            $dir = $basePath . '/' . implode('/', $parts);
            if (!is_dir($dir)) {
                //make directories recursively
                mkdir($dir, 0777, true);
            }
        } else {
            $filePath = realpath(__DIR__ . '/../models') . '/' . $modelClassName . '.php';
        }

        if (is_file($filePath)) {
            return $this->error("Model Already Exists ->" . $filePath);
        }

        if (@file_put_contents($filePath, $modelFileContent)) {
            $this->success("Model Created ->" . $filePath);
        } else {
            $this->error('Invalid Model name');
        }
    }

    private function getClassName($string)
    {
        if (str_contains($string, '/')) {
            return substr($string, strrpos($string, '/') + 1);
        }
        return $string;
    }


    private function getNamespaceName(string $string, string $prefix)
    {
        if (str_contains($string, '/')) {
            $parts = explode('/', $string);
            array_pop($parts);
            $namespace = $prefix . '\\' . implode('\\', $parts);
        } else {
            $namespace =  $prefix;
        }
        return $namespace;
    }

    public function runMigrations()
    {
        //* check if migrations table is available
        $migrationTable = Database::query("SELECT * FROM information_schema.tables WHERE table_schema = ? AND table_name = 'migrations' ", [$_ENV['DB_DATABASE']]);

        if (!isset($migrationTable[0])) {
            $this->info('Creating migrations table');
            $migrationTableClass = 'App\Migrations\m_001_create_migration_table';
            (new $migrationTableClass())->up();
            $this->success('Migrations table imported to database');
        }

        // run remaining migrations
        $importedMigrationsFileNames = array_map(function ($item) {
            return $item['migration'];
        }, Database::select('select migration from migrations'));


        // all migrations in migrations folder
        $migrationFiles = glob('migrations/*.php');
        $isMigratedSomething = false;
        foreach ($migrationFiles as $migrationFile) {
            $pos = strrpos($migrationFile, '/');
            // Get everything after the last slash
            $migrationFileName = substr($migrationFile, $pos + 1);
            $migrationFileName = str_replace('.php', '', $migrationFileName);

            // skip migrations that are already imported
            if (in_array($migrationFileName, $importedMigrationsFileNames)) {
                continue;
            }
            $this->info("Running $migrationFileName migration");

            $migrationTableClass = "App\\Migrations\\$migrationFileName";
            (new $migrationTableClass())->up();
            $this->success("$migrationFileName has been migrated");
            $isMigratedSomething = true;
        }

        if ($isMigratedSomething) {
            $this->success('All migration are migrated');
        } else {
            $this->success('Migrations are upto date');
        }
    }
}
