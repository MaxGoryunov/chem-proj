<?php

namespace Components;

/**
 * Redirection of method calls.
 */
interface Redirection
{

    /**
     * Redirects calls to origin.
     * 
     * @throws Exception if error.
     *
     * @param string       $method method name.
     * @param array<mixed> $args   arguments.
     * @return mixed
     */
    public function __call(string $method, array $args): mixed;
}
