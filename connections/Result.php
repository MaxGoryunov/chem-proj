<?php

namespace Connections;

/**
 * Database query result.
 * @method array<int, array<string, string>> fetchAll(...$args) fetches all
 * rows.
 * @method array<string, string> fetchAssoc() fetches one row in the form of
 * associative array.
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
