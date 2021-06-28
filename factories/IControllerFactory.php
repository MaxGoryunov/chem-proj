<?php

    namespace Factories;

    use Controllers\IController;

    /**
     * interface for factories which can create Controllers
     */
    interface IControllerFactory {

        /**
         * Returns a specified Controller
         *
         * @return IController
         */
        public function getController():IController;
    }