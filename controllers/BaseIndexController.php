<?php

namespace Controllers;

use Components\CurrentPage;
use Models\Listing;

/**
 * Base index controller implementation.
 */
final class BaseIndexController implements IndexController
{

    /**
     * Ctor.
     * 
     * @param Listing $model
     */
    public function __construct(
        /**
         * Listing model.
         * 
         * @var Listing
         */
        private Listing $model
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function model(): Listing
    {
        return $this->model
            ->withOffset(
                (new CurrentPage($_SERVER["REQUEST_URI"]))->value()
            );
    }
}
