<?php

    namespace ControllerActions;

    use Controllers\IController;

    /**
     * Class used to invoke Controller's 'index' method
     */
    class IndexAction extends AbstractAction {

        /**
         * Executes Controller's 'index' method
         * {@inheritDoc}
         */
        public function execute():void {
            $this->controller->index();
        }
    }