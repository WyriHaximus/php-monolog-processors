<?php declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\CopyProcessor;

/**
 * @internal
 */
final class CopyProcessorTest extends TestCase
{
    public function testCopy(): void
    {
        $processor = new CopyProcessor('context.abc', 'context.def');
        $fromRecord = [
            'context' => [
                'abc' => 'value',
            ],
        ];

        $toRecord = $processor($fromRecord);

        self::assertTrue(isset($toRecord['context']['def']));
        self::assertEquals('value', $toRecord['context']['abc']);
        self::assertEquals('value', $toRecord['context']['def']);
    }
}
