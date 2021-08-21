<?php

namespace Models;

use stdClass;

/**
 * Base Id specifc model implementation.
 */
final class BsIdSpecific implements IdSpecific
{

    /**
     * {@inheritDoc}
     */
    public function entity(int $id): object
    {
        return new stdClass();
    }
}
