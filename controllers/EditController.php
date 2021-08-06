<?php

namespace Controllers;

use Models\Editing;

/**
 * Controller for editing models.
 */
interface EditController
{
    /**
     * Returns edited model.
     *
     * @return Editing
     */
    public function model(): Editing;
}
