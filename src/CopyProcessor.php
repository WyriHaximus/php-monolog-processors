<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

use function array_merge_recursive;
use function explode;
use function igorw\assoc_in;
use function igorw\get_in;
use function is_array;

/** @api */
final readonly class CopyProcessor implements ProcessorInterface
{
    /** @var array<string> */
    private array $from;

    /** @var array<string> */
    private array $to;

    public function __construct(string $from, string $to)
    {
        $this->from = explode('.', $from);
        $this->to   = explode('.', $to);
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        $value = get_in($record->toArray(), $this->from);
        if ($value !== null) {
            $base = assoc_in([], $this->to, $value);
            if (is_array($base)) {
                $record = $record->with(...array_merge_recursive($base, ['context' => $record->context, 'extra' => $record->extra]));
            }
        }

        return $record;
    }
}
