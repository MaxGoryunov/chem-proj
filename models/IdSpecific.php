<?php

namespace Models;

/**
 * Model for one entity.
 */
interface IdSpecific
{

    /**
     * Returns an entity.
     *
     * @return object
     */
    public function entity(): object;
}
