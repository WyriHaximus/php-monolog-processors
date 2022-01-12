<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use Monolog\Logger;
use Safe\DateTimeImmutable;

/**
 * @phpstan-import-type Record from Logger
 */
final class Records
{
    /**
     * @phpstan-return Record
     */
    public static function basic(): array
    {
        return [
            'message' => 'message',
            'context' => [],
            'level' => 200,
            'level_name' => 'INFO',
            'channel' => 'logger',
            'extra' => [],
            'datetime' => new DateTimeImmutable(),
        ];
    }
}
