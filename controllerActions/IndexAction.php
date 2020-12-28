<?php

    namespace ControllerActions;

    /**
     * Class used to invoke Controller's 'index' method
     */
    class IndexAction extends AbstractAction implements IIdIndependentControllerAction {

        /**
         * Executes Controller's 'index' method
         * 
         * @todo Implement the if statement with instanceof after the Interface Segregation
         * {@inheritDoc}
         */
        public function execute():void {
            $this->getController()->index();
        }
    }