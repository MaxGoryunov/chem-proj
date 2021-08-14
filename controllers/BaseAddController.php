<?php

namespace Controllers;

use Http\Request;
use Models\Adding;

/**
 * Base controller for adding values to model.
 */
final class BaseAddController implements AddController
{

    /**
     * Ctor.
     * 
     * @param Request $request page request.
     * @param Adding  $model   adding model.
     */
    public function __construct(
        /**
         * Page request.
         *
         * @var Request
         */
        private Request $request,

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
        return $this->model->added($this->request->storage("post"));
    }
}
