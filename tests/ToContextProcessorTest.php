<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use Monolog\LogRecord;
use PHPUnit\Framework\TestCase;
use Safe\DateTimeImmutable;
use WyriHaximus\Monolog\Processors\ToContextProcessor;

/** @internal */
final class ToContextProcessorTest extends TestCase
{
    public function testKeyValue(): void
    {
        $now       = new DateTimeImmutable();
        $extra     = ['foo' => 'bar'];
        $processor = new ToContextProcessor(['datetime', 'extra']);
        $record    = $processor(new LogRecord(...[
            'datetime' => $now,
            'extra' => $extra,
            'context' => ['extra' => ['foo' => 'baz']],
        ] + Records::basic()));

        self::assertArrayHasKey('datetime', $record->context);
        self::assertSame($now, $record->context['datetime']);
        self::assertArrayHasKey('extra', $record->context);
        self::assertSame($extra, $record->context['extra']);
        self::assertSame('bar', $record->context['extra']['foo']); /** @phpstan-ignore-line */
    }
}
