<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

use Monolog\Logger;

use function array_key_exists;

/**
 * @phpstan-import-type Record from Logger
 */
final class ToContextProcessor
{
    /** @var string[] */
    private array $keys;

    /**
     * @param string[] $keys
     *
     * @phpstan-ignore-next-line
     */
    public function __construct(array $keys = ['channel', 'extra', 'datetime'])
    {
        $this->keys = $keys;
    }

    /**
     * @phpstan-param Record $record
     *
     * @phpstan-return Record
     */
    public function __invoke(array $record): array
    {
        foreach ($this->keys as $key) {
            if (! array_key_exists($key, $record)) {
                continue;
            }

            $record['context'][$key] = $record[$key];
        }

        return $record;
    }
}
