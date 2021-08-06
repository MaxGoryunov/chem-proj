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
     * @throws Exception if error.
     *
     * @return array<string, string>
     */
    public function fetchAssoc(): array;
}
