<?php

namespace Controllers;

use Models\Deleting;

/**
 * Base controller for deleting models.
 */
final class BaseDeleteController implements DeleteController
{

    /**
     * Ctor.
     * 
     * @param Deleting $model
     */
    public function __construct(
        /**
         * Deleting model.
         * 
         * @var Deleting
         */
        private Deleting $model
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function model(): Deleting
    {
        return $this->model->deleted(
            end(explode("/", $_SERVER["REQUEST_URI"]))
        );
    }
}
