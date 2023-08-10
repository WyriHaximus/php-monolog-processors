<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

use function microtime;

final class RuntimeProcessor implements ProcessorInterface
{
    private float $start;

    public function __construct()
    {
        $this->start = microtime(true);
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        $record->extra['runtime'] = microtime(true) - $this->start;

        return $record;
    }
}
