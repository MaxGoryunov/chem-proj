<?php

    namespace ControllerActions;

    /**
     * Class used to invoke Controller's 'delete' method
     */
    class DeleteAction extends AbstractAction implements IIdDependentControllerAction {

        /**
         * Executes Controller's 'delete' method
         * 
         * {@inheritDoc}
         */
        public function execute(int $id):void {
            if (method_exists($this->factory, "getProxy")) {
                $controller = $this->factory->getProxy();
            } else {
                $controller = $this->factory->getController();
            }

            $controller->delete($id);
        }
    }