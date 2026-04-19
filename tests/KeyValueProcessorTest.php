<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use Monolog\LogRecord;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\KeyValueProcessor;

/** @internal */
final class KeyValueProcessorTest extends TestCase
{
    #[Test]
    public function keyValue(): void
    {
        $key       = 'key';
        $value     = 'value';
        $processor = new KeyValueProcessor($key, $value);
        $record    = $processor(new LogRecord(...Records::basic()));
        self::assertArrayHasKey($key, $record->extra);
        self::assertSame($value, $record->extra[$key]);
    }
}
