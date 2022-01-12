<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\Processors;

use Monolog\Handler\AbstractHandler;
use Monolog\Logger;

/**
 * @phpstan-import-type Record from Logger
 */
final class FunctionalTestLogger extends AbstractHandler
{
    /** @var callable */
    private $handler;

    public function __construct(callable $handler)
    {
        $this->handler = $handler;
        parent::__construct();
    }

    /**
     * @phpstan-param Record $record
     */
    public function handle(array $record): bool
    {
        ($this->handler)($record);

        return true;
    }
}
