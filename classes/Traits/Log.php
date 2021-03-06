<?php

namespace Src\Traits;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

trait Log
{
    private $debug;
    private $error;
    private $info;
    private $warning;

    protected function logSetup()
    {
        $this->debug = new Logger('DEV');
        $this->error = new Logger('DEV');
        $this->info = new Logger('DEV');
        $this->warning = new Logger('DEV');
        $this->debug->pushHandler(new StreamHandler(__DIR__ . '/../../logs/debug.log', Logger::DEBUG));
        $this->error->pushHandler(new StreamHandler(__DIR__ . '/../../logs/error.log', Logger::ERROR));
        $this->info->pushHandler(new StreamHandler(__DIR__ . '/../../logs/info.log', Logger::INFO));
        $this->warning->pushHandler(new StreamHandler(__DIR__ . '/../../logs/warning.log', Logger::WARNING));
    }

    protected function debug(string $message, array $details = [])
    {
        $this->debug->debug($message, $details);
    }

    protected function error(string $message, array $details = [])
    {
        $this->error->error($message, $details);
    }

    public function info(string $message, array $details = [])
    {
        $this->info->info($message, $details);
    }

    protected function warning(string $message, array $details = [])
    {
        $this->warning->warning($message, $details);
    }
}