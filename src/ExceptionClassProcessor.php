<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Monolog\Logger;
use Throwable;

use function array_key_exists;
use function get_class;

/**
 * @phpstan-import-type Record from Logger
 */
final class ExceptionClassProcessor
{
    /**
     * @phpstan-param Record $record
     *
     * @phpstan-return Record
     */
    public function __invoke(array $record): array
    {
        if (array_key_exists('exception', $record['context']) && $record['context']['exception'] instanceof Throwable) {
            $record['extra']['exception_class'] = get_class($record['context']['exception']);
        }

        return $record;
    }
}
