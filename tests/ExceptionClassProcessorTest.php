<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\ExceptionClassProcessor;

/** @internal */
final class ExceptionClassProcessorTest extends TestCase
{
    public function testNoException(): void
    {
        $input     = Records::basic();
        $processor = new ExceptionClassProcessor();
        $record    = $processor($input);

        self::assertSame($input, $record);
    }

    public function testException(): void
    {
        $processor = new ExceptionClassProcessor();
        $exception = new InvalidArgumentException('fail!');
        $record    = $processor([
            'context' => ['exception' => $exception],
        ] + Records::basic());

        self::assertArrayHasKey('exception_class', $record['extra']);
        self::assertSame(InvalidArgumentException::class, $record['extra']['exception_class']);
    }
}
