<?php declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\KeyValueProcessor;

/**
 * @internal
 */
final class KeyValueProcessorTest extends TestCase
{
    public function testKeyValue(): void
    {
        $key = 'key';
        $value = 'value';
        $processor = new KeyValueProcessor($key, $value);
        $record = $processor([]);
        self::assertSame([
            'extra' => [
                $key => $value,
            ],
        ], $record);
    }
}
