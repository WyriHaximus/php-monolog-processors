<?php declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

final class ExceptionClassProcessor
{
    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        if (isset($record['context']['exception'])) {
            $record['extra']['exception_class'] = get_class($record['context']['exception']);
        }

        return $record;
    }
}
