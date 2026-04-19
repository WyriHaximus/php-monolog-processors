<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use Exception;
use Monolog\LogRecord;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\TraceProcessor;

/** @internal */
final class TraceProcessorTest extends TestCase
{
    #[Test]
    public function noTrace(): void
    {
        $processor = new TraceProcessor();
        $record    = $processor(new LogRecord(...Records::basic()));

        self::assertArrayNotHasKey('trace', $record->extra);
    }

    #[Test]
    public function nonExceptionTrace(): void
    {
        $processor = new TraceProcessor(true);
        $line      = __LINE__ + 1;
        $record    = $processor(new LogRecord(...Records::basic()));

        self::assertArrayHasKey('trace', $record->extra);
        self::assertIsArray($record->extra['trace']);
        self::assertArrayHasKey(0, $record->extra['trace']);
        self::assertIsArray($record->extra['trace'][0]);
        self::assertSame(__FILE__, $record->extra['trace'][0]['file']);
        self::assertSame($line, $record->extra['trace'][0]['line']);
        self::assertGreaterThan(1, $record->extra['trace']);
    }

    #[Test]
    public function exceptionTrace(): void
    {
        $processor = new TraceProcessor();
        $exception = new Exception('fail!');
        $record    = $processor(new LogRecord(...[
            'context' => ['exception' => $exception],
        ] + Records::basic()));

        self::assertArrayHasKey('trace', $record->extra);
        self::assertIsArray($record->extra['trace']);
        self::assertArrayHasKey(0, $record->extra['trace']);
        self::assertIsArray($record->extra['trace'][0]);
        self::assertArrayHasKey('file', $record->extra['trace'][0]);
        self::assertArrayHasKey('line', $record->extra['trace'][0]);
        self::assertSame(__FUNCTION__, $record->extra['trace'][0]['function']);
        self::assertSame(self::class, $record->extra['trace'][0]['class']);
        self::assertGreaterThan(1, $record->extra['trace']);
    }
}
