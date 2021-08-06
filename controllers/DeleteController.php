<?php

namespace Controllers;

use Models\Deleting;

/**
 * Controller for deleting models.
 */
interface DeleteController
{

    /**
     * Returns model with deleted values.
     *
     * @return Deleting
     */
    public function model(): Deleting;
}
