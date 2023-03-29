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

        $stubContent = file_get_contents(__DIR__ . './stubs/Controller.stub');
        echo $stubContent;
    }
}
