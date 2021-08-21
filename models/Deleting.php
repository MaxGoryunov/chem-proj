<?php

namespace Models;

/**
 * Model for deleting values.
 */
interface Deleting
{

    /**
     * Returns model with deleted values.
     *
     * @param int $id
     * @return static
     */
    public function deleted(int $id): static;
}
