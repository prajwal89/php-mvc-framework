<?php

namespace App\Core;

use App\Core\Traits\CliMessage;

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

        if ($this->args[1] == 'make:controller') {
            if (!isset($this->args[2])) {
                exit($this->error('Controller name not specified'));
            }
            $this->makeController($this->args[2]);
        }

        return 'Something went wrong';
    }

    private function makeController($controllerFullName)
    {
        $this->info('Creating controller ' . $controllerFullName);
        $stubPath = realpath(__DIR__ . '/stubs/Controller.stub');
        $this->info('Using stub file -> ' . $stubPath);
        $stubContent = file_get_contents($stubPath);

        $controllerClassName = $this->getControllerName($controllerFullName);
        $controllerNamespace = $this->getControllerNamespace($controllerFullName);

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

    private function getControllerName($string)
    {
        if (str_contains($string, '/')) {
            return substr($string, strrpos($string, '/') + 1);
        }
        return $string;
    }


    private function getControllerNamespace(string $string, string $prefix = 'App\Controllers')
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
}
