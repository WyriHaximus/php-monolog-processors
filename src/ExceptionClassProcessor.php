<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;
use Throwable;

use function array_key_exists;
use function get_class;

final class ExceptionClassProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        if (array_key_exists('exception', $record->context) && $record->context['exception'] instanceof Throwable) {
            $record->extra['exception_class'] = get_class($record->context['exception']);
        }

        return $record;
    }
}
