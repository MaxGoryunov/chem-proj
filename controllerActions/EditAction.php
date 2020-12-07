<?php

    namespace ControllerActions;

    /**
     * Class used to invoke Controller's 'edit' method
     */
    class EditAction extends AbstractAction implements IIdDependentControllerAction {

        /**
         * Executes Controller's 'edit' method
         * 
         * {@inheritDoc}
         */
        public function execute(int $id):void {
            if (method_exists($this->factory, "getProxy")) {
                $controller = $this->factory->getProxy();
            } else {
                $controller = $this->factory->getController();
            }

            $controller->edit($id);
        }
    }