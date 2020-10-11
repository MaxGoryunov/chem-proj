<?php

    namespace ControllerActions;

    /**
     * Class used to invoke Controller's 'edit' method
     */
    class EditAction extends AbstractAction implements IIdDependentControllerAction {

        /**
         * Executes Controller's 'edit' method
         * {@inheritDoc}
         */
        public function execute(int $id):void {
            $this->controller->edit($id);
        }
    }