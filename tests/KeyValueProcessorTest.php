<?php declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\KeyValueProcessor;

final class KeyValueProcessorTest extends TestCase
{
    public function testKeyValue()
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
