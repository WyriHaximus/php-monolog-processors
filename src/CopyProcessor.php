<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Monolog\Logger;

use function explode;
use function igorw\assoc_in;
use function igorw\get_in;

/** @phpstan-import-type Record from Logger */
final class CopyProcessor
{
    /** @var string[] */
    private array $from;

    /** @var string[] */
    private array $to;

    public function __construct(string $from, string $to)
    {
        $this->from = explode('.', $from);
        $this->to   = explode('.', $to);
    }

    /**
     * @phpstan-param Record $record
     *
     * @phpstan-return Record
     */
    public function __invoke(array $record): array
    {
        $value = get_in($record, $this->from);
        if ($value !== null) {
            $record = assoc_in($record, $this->to, $value);
        }

        return $record;
    }
}
