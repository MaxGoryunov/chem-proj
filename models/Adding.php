<?php

namespace Models;

/**
 * Model for adding values.
 */
interface Adding
{
    /**
     * Returns model with added data.
     *
     * @param array<mixed> $data
     * @return static
     */
    public function added(array $data): static;
}
