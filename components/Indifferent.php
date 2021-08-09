<?php

namespace Components;

/**
 * Interface for objects on which any method can be called.
 */
interface Indifferent
{

    /**
     * Handles any method call.
     *
     * @param string $method
     * @param array<mixed> $args
     * @return mixed
     */
    public function __call(string $method, array $args): mixed;
}
