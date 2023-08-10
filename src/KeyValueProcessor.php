<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

final class KeyValueProcessor implements ProcessorInterface
{
    public function __construct(private string $key, private mixed $value)
    {
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        $record->extra[$this->key] = $this->value;

        return $record;
    }
}
