<?php

namespace Models;

/**
 * Model which can list values.
 */
interface Listing
{
    /**
     * Returns model with modified count of values.
     *
     * @param int $count
     * @return static
     */
    public function withCount(int $count): static;

    /**
     * Returns model with modified offset.
     *
     * @param int $offset
     * @return static
     */
    public function withOffset(int $offset): static;

    /**
     * Returns a list of values.
     *
     * @return mixed[]
     */
    public function list(): array;
}
