<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use Monolog\Handler\AbstractHandler;
use Monolog\LogRecord;

final class FunctionalTestLogger extends AbstractHandler
{
    /** @var callable */
    private $handler;

    public function __construct(callable $handler)
    {
        $this->handler = $handler;

        parent::__construct();
    }

    public function handle(LogRecord $record): bool
    {
        ($this->handler)($record);

        return true;
    }
}
