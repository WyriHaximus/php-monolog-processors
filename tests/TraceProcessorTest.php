<?php declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\TraceProcessor;

/**
 * @internal
 */
final class TraceProcessorTest extends TestCase
{
    public function testNoTrace(): void
    {
        $processor = new TraceProcessor();
        $record = $processor([]);

        self::assertFalse(isset($record['extra']['trace']));
    }

    public function testNonExceptionTrace(): void
    {
        $processor = new TraceProcessor(true);
        $line = __LINE__ + 1;
        $record = $processor([]);

        self::assertTrue(isset($record['extra']['trace']));
        self::assertTrue(isset($record['extra']['trace'][0]));
        self::assertSame(__FILE__, $record['extra']['trace'][0]['file']);
        self::assertSame($line, $record['extra']['trace'][0]['line']);
        self::assertThat(\count($record['extra']['trace']), self::greaterThan(1));
    }

    public function testExceptionTrace(): void
    {
        $processor = new TraceProcessor();
        $exception = new \Exception('fail!');
        $record = $processor([
            'context' => [
                'exception' => $exception,
            ],
        ]);

        self::assertTrue(isset($record['extra']['trace']));
        self::assertTrue(isset($record['extra']['trace'][0]));
        self::assertTrue(isset($record['extra']['trace'][0]['file']));
        self::assertTrue(isset($record['extra']['trace'][0]['line']));
        self::assertSame(__FUNCTION__, $record['extra']['trace'][0]['function']);
        self::assertSame(__CLASS__, $record['extra']['trace'][0]['class']);
        self::assertThat(\count($record['extra']['trace']), self::greaterThan(1));
    }
}
