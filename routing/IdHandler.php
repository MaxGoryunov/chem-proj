<?php

    namespace Routing;

use ControllerActions\ControllerAction;

/**
     * Class for handling id extraction from user URI
     */
    class IdHandler extends AbstractHandler {

        /**
         * @inheritDoc
         */
        protected function fillData(array $partedUri, ControllerAction $action):ControllerAction {
            if ((isset($partedUri[4])) && (preg_match("/([1-9][0-9]*$)/", $partedUri[4]))) {
                $action->setData(["id" => (int)$partedUri[4]]);
            }
            
            return $action;
        }
    }