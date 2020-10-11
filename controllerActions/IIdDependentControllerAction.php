<?php

    namespace ControllerActions;

    /**
     * Interface which forces all the actions with id to have similar behavior
     */
    interface IIdDependentControllerAction {
        
        /**
         * Executes Controller's method with id
         *
         * @return void
         */
        public function execute(int $id):void;
    }