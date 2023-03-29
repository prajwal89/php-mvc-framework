<?php

namespace App\Core\Traits;

trait CliMessage
{
    private function info($message)
    {
        echo "\033[34m" . $message . "\033[0m" . PHP_EOL;
    }

    private function success($message)
    {
        echo "\033[32m" . $message . "\033[0m" . PHP_EOL;
    }

    private function error($message)
    {
        echo "\033[31m" . $message . "\033[0m" . PHP_EOL;
    }
}
