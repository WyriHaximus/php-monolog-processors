<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\RuntimeProcessor;

use function sleep;

/** @internal */
final class RuntimeProcessorTest extends TestCase
{
    public function testKeyValue(): void
    {
        $processor      = new RuntimeProcessor();
        $baselineRecord = $processor(Records::basic());
        self::assertArrayHasKey('runtime', $baselineRecord['extra']);
        self::assertIsFloat($baselineRecord['extra']['runtime']);
        sleep(1);
        $record = $processor(Records::basic());
        self::assertArrayHasKey('runtime', $record['extra']);
        self::assertIsFloat($record['extra']['runtime']);
        self::assertGreaterThan($baselineRecord['extra']['runtime'], $record['extra']['runtime']);
        self::assertGreaterThan(1, $record['extra']['runtime']);
    }
}
