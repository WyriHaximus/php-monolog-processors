<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

use function array_key_exists;

final class ToContextProcessor implements ProcessorInterface
{
    /**
     * @param array<string> $keys
     *
     * @phpstan-ignore-next-line
     */
    public function __construct(private array $keys = ['channel', 'extra', 'datetime'])
    {
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        foreach ($this->keys as $key) {
            if (! array_key_exists($key, $record->toArray())) {
                continue;
            }

            $record = $record->with(context: [$key => $record->toArray()[$key]] + $record->toArray()['context']);
        }

        return $record;
    }
}
