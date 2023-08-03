<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Monolog\Logger;

/** @phpstan-import-type Record from Logger */
final class KeyValueProcessor
{
    public function __construct(private string $key, private mixed $value)
    {
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
