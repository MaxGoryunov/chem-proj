<?php

namespace Controllers;

use Models\Editing;

/**
 * Base controller for editing models.
 */
final class BaseEditController implements EditController
{

    public function __construct(
        /**
         * Editing model.
         * 
         * @var Editing
         */
        private Editing $model
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function model(): Editing
    {
        return $this->model->edited($_POST);
    }
}
