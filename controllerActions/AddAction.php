<?php

    namespace ControllerActions;

    /**
     * Class used to invoke Controller's 'index' method
     */
    class AddAction extends AbstractAction implements IIdIndependentControllerAction {

        /**
         * Executes Controller's 'add' method
         *
         * @return void
         */
        public function execute():void {
            if (method_exists($this->factory, "getProxy")) {
                $controller = $this->factory->getProxy();
            } else {
                $controller = $this->factory->getController();
            }
            
            $controller->add();
        }
    }