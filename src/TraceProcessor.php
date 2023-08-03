<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;
use Throwable;

use function array_key_exists;
use function debug_backtrace;

use const DEBUG_BACKTRACE_IGNORE_ARGS;

final class TraceProcessor implements ProcessorInterface
{
    /** @phpstan-ignore-next-line */
    public function __construct(private bool $always = false)
    {
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        if (array_key_exists('exception', $record->context) && $record->context['exception'] instanceof Throwable) {
            $record->extra['trace'] = $record->context['exception']->getTrace();
            foreach ($record->extra['trace'] as $index => $line) {
                if (! array_key_exists('args', $line)) {
                    continue;
                }

                unset($record->extra['trace'][$index]['args']);
            }
        }

        if ($this->always && ! array_key_exists('trace', $record->extra)) {
            $record->extra['trace'] = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        }

        return $record;
    }
}
