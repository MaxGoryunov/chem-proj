<?php

    namespace Routing;

    /**
     * Class for handling id extraction from user URI
     */
    class IdHandler implements IRoutingHandler {

        /**
         * Contains next handler in the CoR
         *
         * @var IRoutingHandler
         */
        private $nextHandler;

        /**
         * {@inheritDoc}
         */
        public function setNextHandler(IRoutingHandler $nextHandler):IRoutingHandler {
            $this->nextHandler = $nextHandler;

            return $nextHandler;
        }

        /**
         * {@inheritDoc}
         */
        public function handle(array $partedUri, array $invokeData = []):array {
            if ((isset($partedUri[4])) && (preg_match("/([1-9][0-9]*$)/", $partedUri[4]))) {
                $invokeData["id"] = (int)$partedUri[4];
            }
            if (isset($this->nextHandler)) {
                return $this->nextHandler->handle($partedUri, $invokeData);
            }

            return $invokeData;
        }
    }