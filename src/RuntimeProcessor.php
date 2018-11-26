<?php declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

final class RuntimeProcessor
{
    /**
     * @var float
     */
    private $start;

    public function __construct()
    {
        $this->start = \microtime(true);
    }

    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        $record['extra']['runtime'] = \microtime(true) - $this->start;

        return $record;
    }
}
