<?php

namespace Fakes;

use mysqli_result;

/**
 * Fake mysqli_result for testing.
 */
final class MysqliResult extends mysqli_result
{

    /**
     * Ctor.
     * 
     * @param array<string, mixed> $dummies dummy data.
     */
    public function __construct(
        /**
         * Dummy data to return instead of original value.
         * 
         * @var array<string, mixed>
         */
        private array $dummies
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function fetch_assoc(): mixed
    {
        return $this->dummies[__FUNCTION__];
    }

    /**
     * Returns dummy data.
     *
     * @param string $name
     * @param array<mixed> $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        return $this->dummies[$name];
    }
}
