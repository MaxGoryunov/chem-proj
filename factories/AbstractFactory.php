<?php

    namespace Factories;

use Controllers\IController;

    abstract class AbstractFactory implements IControllerFactory {
        
        /**
         * Temporary solution
         *
         * @return IController
         */
        public function getController():IController {
            return new class implements IController {

                
            };
        }
    }