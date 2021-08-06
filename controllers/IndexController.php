<?php

namespace Controllers;

use Models\Listing;

/**
 * Controller for listing models.
 */
interface IndexController
{
    /**
     * Returns modified model.
     *
     * @return Listing
     */
    public function model(): Listing;
}
