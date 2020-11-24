<?php

    namespace Routing;

    /**
     * Class for handling id extraction from user URI
     */
    class IdHandler extends AbstractHandler {

        /**
         * {@inheritDoc}
         */
        public function handle(array $partedUri, array $invokeData = []):array {
            if ((isset($partedUri[4])) && (preg_match("/([1-9][0-9]*$)/", $partedUri[4]))) {
                $invokeData["id"] = (int)$partedUri[4];
            }
            
            return $this->passToNext($partedUri, $invokeData);
        }
    }