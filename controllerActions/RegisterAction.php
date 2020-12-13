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
            if (method_exists($this->factory, "getProxy")) {
                $controller = $this->factory->getProxy();
            } else {
                $controller = $this->factory->getController();
            }

            $controller->register();
        }
    }