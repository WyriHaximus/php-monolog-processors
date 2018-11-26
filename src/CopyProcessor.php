<?php declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use function igorw\assoc_in;
use function igorw\get_in;

final class CopyProcessor
{
    /**
     * @var string[]
     */
    private $from;

    /**
     * @var string[]
     */
    private $to;

    /**
     * @param string $from
     * @param string $to
     */
    public function __construct(string $from, string $to)
    {
        $this->from = \explode('.', $from);
        $this->to = \explode('.', $to);
    }

    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        $value = get_in($record, $this->from);
        if ($value !== null) {
            $record = assoc_in($record, $this->to, $value);
        }

        return $record;
    }
}
