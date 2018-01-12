<?php declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\RuntimeProcessor;
use WyriHaximus\Monolog\Processors\TraceProcessor;

final class TraceProcessorTest extends TestCase
{
    public function testKeyValue()
    {
        $processor = new TraceProcessor();
        $line = __LINE__ + 1;
        $record = $processor([]);

        self::assertTrue(isset($record['extra']['trace'][0]));
        self::assertSame(__FILE__, $record['extra']['trace'][0]['file']);
        self::assertSame($line, $record['extra']['trace'][0]['line']);
        self::assertThat(count($record['extra']['trace']), self::greaterThan(1));
    }
}
