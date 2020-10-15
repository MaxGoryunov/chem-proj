<?php

    namespace ControllerActions;

    /**
     * Class used to invoke Controller's 'delete' method
     */
    class DeleteAction extends AbstractAction implements IIdDependentControllerAction {

        public function execute(int $id):void {
            $this->controller->delete($id);
        }
    }