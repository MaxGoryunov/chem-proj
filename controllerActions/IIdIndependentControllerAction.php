<?php

    namespace ControllerActions;

    /**
     * Interface which forces all the actions without id to have similar behavior
     */
    interface IIdIndependentControllerAction {
        
        /**
         * Executes Controller's method without id
         *
         * @return void
         */
        public function execute():void;
    }