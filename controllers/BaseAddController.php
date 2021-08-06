<?php

namespace Controllers;

use Models\Adding;

/**
 * Base controller for adding values to model.
 */
final class BaseAddController implements AddController
{

    /**
     * Ctor.
     * 
     * @param Adding $model
     */
    public function __construct(
        /**
         * Adding model.
         * 
         * @var Adding
         */
        private Adding $model
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function model(): Adding
    {
        return $this->model->added($_POST);
    }
}
