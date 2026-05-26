<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

use function array_key_exists;

/** @api */
final readonly class ToContextProcessor implements ProcessorInterface
{
    private const array DEFAULT_KEYS = ['channel', 'extra', 'datetime'];

    /**
     * @param array<string> $keys
     *
     * @phpstan-ignore ergebnis.noConstructorParameterWithDefaultValue
     */
    public function __construct(private array $keys = self::DEFAULT_KEYS)
    {
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        foreach ($this->keys as $key) {
            if (! array_key_exists($key, $record->toArray())) {
                continue;
            }

            $record = $record->with(
                context: [
                    $key => $record->toArray()[$key],
                ] + $record->toArray()['context'],
            );
        }

        return $record;
    }
}
