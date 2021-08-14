<?php

namespace Routing;

/**
 * URI.
 */
interface URI
{

    /**
     * Returns an array of URI subparts.
     *
     * @return string[]
     */
    public function parted(): array;

    /**
     * Returns number of subparts in the URI.
     *
     * @return int
     */
    public function count(): int;
}
