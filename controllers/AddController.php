<?php

namespace Controllers;

use Models\Adding;

/**
 * Controller for adding values to model.
 */
interface AddController
{

    /**
     * Returns model with added values.
     *
     * @return Adding
     */
    public function model(): Adding;
}
