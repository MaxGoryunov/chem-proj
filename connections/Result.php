<?php

namespace Connections;

/**
 * Database query result.
 */
interface Result
{

    /**
     * Returns assoc result array.
     *
     * @return array<string, string>
     */
    public function fetchAssoc(): array;
}
