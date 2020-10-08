<?php

    namespace ControllerActions;

    use Controllers\IController;

    /**
     * Base class for implementing other controller actions
     */
    abstract class AbstractAction implements IControllerAction {
        
        /**
         * Contains controller object on which the method will be invoked
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
    }