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
     * @param int $id entity id.
     * @return object
     */
    public function entity(int $id): object;
}
