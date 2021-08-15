<?php

namespace Controllers;

use Http\Request;
use Models\Editing;

/**
 * Base controller for editing models.
 */
final class BaseEditController implements EditController
{

    /**
     * Ctor.
     * 
     * @param Request $request page request.
     * @param Editing $model   editing model.
     */
    public function __construct(
        /**
         * Page request.
         *
         * @var Request
         */
        private Request $request,

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
        return $this->model->edited($this->request->storage("post"));
    }
}
