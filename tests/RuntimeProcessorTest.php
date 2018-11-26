<?php declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\RuntimeProcessor;

/**
 * @internal
 */
final class RuntimeProcessorTest extends TestCase
{
    public function testKeyValue(): void
    {
        $processor = new RuntimeProcessor();
        $record = $processor([]);
        self::assertTrue(isset($record['extra']['runtime']));
        self::assertInternalType('float', $record['extra']['runtime']);
    }
}
