<?php

namespace Connections;

/**
 * database query result.
 */
interface Result
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
