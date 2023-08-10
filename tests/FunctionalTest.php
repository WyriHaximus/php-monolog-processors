<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use Exception;
use Monolog\Level;
use Monolog\Logger;
use Monolog\LogRecord;
use Monolog\Utils;
use Psr\Log\LogLevel;
use WyriHaximus\Monolog\Processors\CopyProcessor;
use WyriHaximus\Monolog\Processors\ExceptionClassProcessor;
use WyriHaximus\Monolog\Processors\KeyValueProcessor;
use WyriHaximus\Monolog\Processors\RuntimeProcessor;
use WyriHaximus\Monolog\Processors\ToContextProcessor;
use WyriHaximus\Monolog\Processors\TraceProcessor;
use WyriHaximus\TestUtilities\TestCase;

use function array_key_exists;
use function sprintf;

final class FunctionalTest extends TestCase
{
    /** @phpstan-var array<LogRecord> */
    private array $logs = [];

    public function testBasic(): void
    {
        $monolog = $this->provideMonolog();

        $monolog->info('message');

        self::assertCount(1, $this->logs);
        self::assertArrayHasKey('datetime', $this->logs[0]->context);
        self::assertArrayHasKey('runtime', $this->logs[0]->extra);
        self::assertSame($this->logs[0]->datetime, $this->logs[0]->context['datetime']);
//        unset($this->logs[0]['datetime'], $this->logs[0]->context['datetime']);

        self::assertIsFloat($this->logs[0]->extra['runtime']);
        self::assertIsFloat($this->logs[0]->context['extra']['runtime']);
        self::assertSame($this->logs[0]->extra['runtime'], $this->logs[0]->context['extra']['runtime']);
//        unset($this->logs[0]->extra['runtime'], $this->logs[0]->context->extra['runtime']);

        self::assertSame('message', $this->logs[0]->message);
        self::assertSame([
            'datetime' => $this->logs[0]->datetime,
            'extra' => [
                'runtime' => $this->logs[0]->extra['runtime'],
                'version' => '1.2.3',
            ],
            'channel' => 'logger',
        ], $this->logs[0]->context);
        self::assertSame(Level::Info, $this->logs[0]->level);
        self::assertSame('logger', $this->logs[0]->channel);
        self::assertSame([
            'runtime' => $this->logs[0]->extra['runtime'],
            'version' => '1.2.3',
        ], $this->logs[0]->extra);
    }

    public function testException(): void
    {
        $monolog = $this->provideMonolog();

        $e       = new Exception('Poof!');
        $message = sprintf('Uncaught Exception %s: "%s" at %s line %s', Utils::getClass($e), $e->getMessage(), $e->getFile(), $e->getLine());
        $trace   = $e->getTrace();
        foreach ($trace as $index => $line) {
            if (! array_key_exists('args', $line)) {
                continue;
            }

            unset($trace[$index]['args']);
        }

        $monolog->log(
            LogLevel::ERROR,
            $message,
            ['exception' => $e],
        );

        self::assertCount(1, $this->logs);
        self::assertArrayHasKey('datetime', $this->logs[0]->context);
        self::assertArrayHasKey('runtime', $this->logs[0]->extra);
        self::assertSame($this->logs[0]['datetime'], $this->logs[0]->context['datetime']);
//        unset($this->logs[0]['datetime'], $this->logs[0]->context['datetime']);

        self::assertIsFloat($this->logs[0]->extra['runtime']);
        self::assertIsFloat($this->logs[0]->context['extra']['runtime']);
        self::assertSame($this->logs[0]->extra['runtime'], $this->logs[0]->context['extra']['runtime']);
//        unset($this->logs[0]->extra['runtime'], $this->logs[0]->context->extra['runtime']);

        self::assertSame($message, $this->logs[0]->message);
        self::assertSame([
            'datetime' => $this->logs[0]->datetime,
            'extra' => [
                'class_exception' => 'Exception',
                'trace' => $trace,
                'runtime' => $this->logs[0]->extra['runtime'],
                'version' => '1.2.3',
                'exception_class' => 'Exception',
            ],
            'channel' => 'logger',
            'exception' => $e,
        ], $this->logs[0]->context);
        self::assertSame(Level::Error, $this->logs[0]->level);
        self::assertSame('logger', $this->logs[0]->channel);
        self::assertSame([
            'class_exception' => 'Exception',
            'trace' => $trace,
            'runtime' => $this->logs[0]->extra['runtime'],
            'version' => '1.2.3',
            'exception_class' => 'Exception',
        ], $this->logs[0]->extra);
    }

    /** @return iterable<callable> */
    private function provideProcessors(): iterable
    {
        yield new ToContextProcessor();
        yield new CopyProcessor('extra.exception_class', 'extra.class_exception');
        yield new ExceptionClassProcessor();
        yield new KeyValueProcessor('version', '1.2.3');
        yield new RuntimeProcessor();
        yield new TraceProcessor();
    }

    private function provideMonolog(): Logger
    {
        $monolog = new Logger('logger');

        $monolog->pushHandler(new FunctionalTestLogger(function ($log): void {
            $this->logs[] = $log;
        }));

        foreach ($this->provideProcessors() as $processor) {
            $monolog->pushProcessor($processor);
        }

        return $monolog;
    }
}
