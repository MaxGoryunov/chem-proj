<?php

namespace Controllers;

use Components\CurrentPage;
use Http\Request;
use Models\Listing;

/**
 * Base index controller implementation.
 */
final class BaseIndexController implements IndexController
{

    /**
     * Ctor.
     * 
     * @param Request $request page request.
     * @param Listing $model   listing model.
     */
    public function __construct(
        /**
         * Page request.
         *
         * @var Request
         */
        private Request $request,

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
                (new CurrentPage($this->request->uri()))->value()
            );
    }
}
