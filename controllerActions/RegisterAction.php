<?php

    namespace ControllerActions;

    /**
     * Class used to invoke Controller's 'register' method
     */
    class RegisterAction extends AbstractAction implements IIdIndependentControllerAction {

        /**
         * Executes Controller's 'register' method
         *
         * @return void
         */
        public function execute():void {
            $this->controller->register();
        }
    }