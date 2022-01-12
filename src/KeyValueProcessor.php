<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Monolog\Logger;

/**
 * @phpstan-import-type Record from Logger
 */
final class KeyValueProcessor
{
    private string $key;

    private mixed $value;

    public function __construct(string $key, mixed $value)
    {
        $this->key   = $key;
        $this->value = $value;
    }

    /**
     * @phpstan-param Record $record
     *
     * @phpstan-return Record
     */
    public function __invoke(array $record): array
    {
        $record['extra'][$this->key] = $this->value;

        return $record;
    }
}
