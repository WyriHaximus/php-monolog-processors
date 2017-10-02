<?php declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

final class ToContextProcessor
{
    /**
     * @var string[]
     */
    private $keys;

    /**
     * @param string[] $keys
     */
    public function __construct(array $keys = ['channel', 'extra', 'datetime'])
    {
        $this->keys = $keys;
    }

    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        foreach ($this->keys as $key) {
            if (!isset($record[$key])) {
                continue;
            }
            $record['context'][$key] = $record[$key];
        }

        return $record;
    }
}
