<?php

namespace App\Services\Common\Helpers\Logger;

interface LoggerContract
{
    public function info($message, array $context = []);

    public function error($message, array $context = []);
}
