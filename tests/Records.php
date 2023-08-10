<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use Monolog\Level;
use Safe\DateTimeImmutable;

final class Records
{
    /** @return array{message: string, context: array<mixed>, level: Level::Info, channel: string, extra: array<mixed>, datetime: \DateTimeImmutable} */
    public static function basic(): array
    {
        return [
            'message' => 'message',
            'context' => [],
            'level' => Level::Info,
            'channel' => 'logger',
            'extra' => [],
            'datetime' => new DateTimeImmutable(),
        ];
    }
}
