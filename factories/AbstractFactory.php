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

                public function index():void {
                    
                }

                public function add():void {
                    
                }

                public function edit(int $id):void {
                    
                }

                public function delete(int $id):void {
                    
                }
            };
        }
    }