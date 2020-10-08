<?php

    namespace ControllerActions;

    /**
     * Interface which forces all the actions to have similar behavior
     */
    interface IControllerAction {
        
        /**
         * Executes Controller's method
         *
         * @return void
         */
        public function execute():void;
    }