<?php declare(strict_types=1);

namespace WyriHaximus\Monolog\Processors;

final class KeyValueProcessor
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function __construct(string $key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        $record['extra'][$this->key] = $this->value;

        return $record;
    }
}
