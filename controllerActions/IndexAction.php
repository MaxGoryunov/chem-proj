<?php

    namespace ControllerActions;

use Controllers\IController;

/**
     * Class used to invoke Controller's 'index' method
     */
    class IndexAction {

        /**
         * Contains controller object on which 'index' method will be invoked
         *
         * @var IController
         */
        private $controller;

        /**
         * @param IController $controller
         */
        public function __construct(IController $controller) {
            $this->controller = $controller;
        }

        public function execute():void {
            $this->controller->index();
        }
    }