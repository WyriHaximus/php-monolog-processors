<?php declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Throwable;

final class TraceProcessor
{
    /**
     * @var bool
     */
    private $always = false;

    /**
     * @param bool $always
     */
    public function __construct(bool $always = false)
    {
        $this->always = $always;
    }

    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        if (isset($record['context']['exception']) && $record['context']['exception'] instanceof Throwable) {
            $record['extra']['trace'] = $record['context']['exception']->getTrace();
            foreach ($record['extra']['trace'] as $index => $line) {
                if (!isset($line['args'])) {
                    continue;
                }

                unset($record['extra']['trace'][$index]['args']);
            }
        }

        if ($this->always && !isset($record['extra']['trace'])) {
            $record['extra']['trace'] = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS);
        }

        return $record;
    }
}
