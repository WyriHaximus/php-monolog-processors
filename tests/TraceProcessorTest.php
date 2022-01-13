<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use Exception;
use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\TraceProcessor;

use function count;

/**
 * @internal
 */
final class TraceProcessorTest extends TestCase
{
    public function testNoTrace(): void
    {
        $processor = new TraceProcessor();
        $record    = $processor(Records::basic());

        self::assertArrayNotHasKey('trace', $record['extra']);
    }

    public function testNonExceptionTrace(): void
    {
        $processor = new TraceProcessor(true);
        $line      = __LINE__ + 1;
        $record    = $processor(Records::basic());

        self::assertArrayHasKey('trace', $record['extra']);
        self::assertArrayHasKey(0, $record['extra']['trace']);
        self::assertSame(__FILE__, $record['extra']['trace'][0]['file']);
        self::assertSame($line, $record['extra']['trace'][0]['line']);
        self::assertThat(count($record['extra']['trace']), self::greaterThan(1));
    }

    public function testExceptionTrace(): void
    {
        $processor = new TraceProcessor();
        $exception = new Exception('fail!');
        $record    = $processor([
            'context' => ['exception' => $exception],
        ] + Records::basic());

        self::assertArrayHasKey('trace', $record['extra']);
        self::assertArrayHasKey(0, $record['extra']['trace']);
        self::assertArrayHasKey('file', $record['extra']['trace'][0]);
        self::assertArrayHasKey('line', $record['extra']['trace'][0]);
        self::assertSame(__FUNCTION__, $record['extra']['trace'][0]['function']);
        self::assertSame(self::class, $record['extra']['trace'][0]['class']);
        self::assertThat(count($record['extra']['trace']), self::greaterThan(1));
    }
}
