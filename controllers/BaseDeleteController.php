<?php

namespace Controllers;

use Http\Request;
use Models\Deleting;

/**
 * Base controller for deleting models.
 */
final class BaseDeleteController implements DeleteController
{

    /**
     * Ctor.
     * 
     * @param Request  $request page request.
     * @param Deleting $model   deleting model.
     */
    public function __construct(
        /**
         * Page request.
         *
         * @var Request
         */
        private Request $request,

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
            end(explode("/", $this->request->uri()))
        );
    }
}
