<?php declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use Exception;
use PHPUnit\Framework\TestCase;
use WyriHaximus\Monolog\Processors\ExceptionClassProcessor;

final class ExceptionClassProcessorTest extends TestCase
{
    public function testNoException()
    {
        $processor = new ExceptionClassProcessor();
        $record = $processor([]);

        self::assertSame([], $record);
    }

    public function testException()
    {
        $processor = new ExceptionClassProcessor();
        $exception = new Exception('fail!');
        $record = $processor([
            'context' => [
                'exception' => $exception,
            ],
        ]);

        self::assertTrue(isset($record['extra']['exception_class']));
        self::assertSame(Exception::class, $record['extra']['exception_class']);
    }
}
