<?php

namespace Models;

/**
 * Model for editing values.
 */
interface Editing
{

    /**
     * Returns edited model.
     *
     * @param mixed[] $data
     * @return static
     */
    public function edited(array $data): static;
}
