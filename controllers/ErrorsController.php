<?php

    namespace Controllers;

use Factories\UsersFactory;

/**
     * Class containing Error controller logic
     */
    class ErrorsController extends AbstractController {

        /**
         * Creates a page when URL matches nothing
         *
         * @return void
         */
        public function notFound():void {
            $title          = " Page not found";
            $fullUserStatus = (new UsersFactory())->getModel()->getUserFullStatus();

            $viewData = array_merge($fullUserStatus, compact("title"));

            $this->getView()->render(__FUNCTION__, $viewData);
        }
    }