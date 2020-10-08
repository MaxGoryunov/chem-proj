<?php

    namespace ControllerActions;

    /**
     * Class used to invoke Controller's 'index' method
     */
    class AddAction extends AbstractAction {

        /**
         * Executes Controller's 'add' method
         *
         * @return void
         */
        public function execute():void {
            $this->controller->add();
        }
    }