<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Monolog\Logger;

use function microtime;

/** @phpstan-import-type Record from Logger */
final class RuntimeProcessor
{
    private float $start;

    public function __construct()
    {
        $this->start = microtime(true);
    }

    /**
     * @phpstan-param Record $record
     *
     * @phpstan-return Record
     */
    public function __invoke(array $record): array
    {
        $record['extra']['runtime'] = microtime(true) - $this->start;

        return $record;
    }
}
