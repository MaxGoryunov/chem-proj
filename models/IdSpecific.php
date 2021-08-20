<?php

namespace Models;

/**
 * Model for one entity.
 */
interface IdSpecific
{

    /**
     * returns an entity.
     *
     * @param int $id entity id.
     * @return object
     */
    public function entity(int $id): object;
}
