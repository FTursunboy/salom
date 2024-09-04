<?php

namespace App\Services\Common\Helpers\Logger;

use Carbon\Carbon;
use Monolog\Handler\StreamHandler;

class Logger implements LoggerContract
{
    protected \Monolog\Logger $logger;

    /**
     * Logger constructor.
     * @param $folder
     * @param string $serviceName
     * @throws \Exception
     */
    public function __construct($folder, string $serviceName = '')
    {
        $this->logger = new \Monolog\Logger($serviceName);
        $this->logger->pushHandler(new StreamHandler(sprintf('%s/logs/%s/info-%s.log', storage_path(), $folder, Carbon::now()->toDateString()), \Monolog\Logger::INFO));
        $this->logger->pushHandler(new StreamHandler(sprintf('%s/logs/%s/error-%s.log', storage_path(), $folder, Carbon::now()->toDateString()), \Monolog\Logger::ERROR));
    }

    public function info($message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function error($message, array $context = []): void
    {
        $this->logger->error($message, $context);
    }
}
