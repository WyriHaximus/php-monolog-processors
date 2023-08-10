<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use Monolog\LogRecord;
use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\CopyProcessor;

/** @internal */
final class CopyProcessorTest extends TestCase
{
    public function testCopy(): void
    {
        $processor  = new CopyProcessor('context.abc', 'context.def');
        $fromRecord = new LogRecord(...[
            'context' => ['abc' => 'value'],
        ] + Records::basic());

        $toRecord = $processor($fromRecord);

        self::assertArrayHasKey('def', $toRecord->context);
        self::assertEquals('value', $toRecord->context['abc']);
        self::assertEquals('value', $toRecord->context['def']);
    }
}
