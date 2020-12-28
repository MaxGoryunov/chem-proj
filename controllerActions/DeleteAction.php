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
            $this->getController()->delete($id);
        }
    }