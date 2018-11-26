<?php declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\ToContextProcessor;

/**
 * @internal
 */
final class ToContextProcessorTest extends TestCase
{
    public function testKeyValue(): void
    {
        $now = new \DateTimeImmutable();
        $extra = [
            'foo' => 'bar',
        ];
        $processor = new ToContextProcessor(['datetime', 'extra']);
        $record = $processor([
            'datetime' => $now,
            'extra' => $extra,
            'excluded' => [],
        ]);

        self::assertSame(
            [
                'datetime' => $now,
                'extra' => $extra,
                'excluded' => [],
                'context' => [
                    'datetime' => $now,
                    'extra' => $extra,
                ],
            ],
            $record
        );
    }
}
