<?php

    namespace Routing;

    abstract class AbstractHandler implements IRoutingHandler {
        
        /**
         * Contains next handler in the CoR
         *
         * @var IRoutingHandler
         */
        protected $nextHandler;

        /**
         * {@inheritDoc}
         */
        public function setNextHandler(IRoutingHandler $nextHandler):IRoutingHandler {
            $this->nextHandler = $nextHandler;

            return $nextHandler;
        }

        /**
         * Passes the URI to the next Handler in the CoR if it exists
         *
         * @param string[] $partedUri  - URI string as an array
         * @param string[] $invokeData - data for Router method
         * @return string[]
         */
        protected function passToNext(array $partedUri, array $invokeData = []):array {
            if (isset($this->nextHandler)) {
                return $this->nextHandler->handle($partedUri, $invokeData);
            }

            return $invokeData;
        }

        /**
         * {@inheritDoc}
         */
        public function handle(array $partedUri, array $invokeData = []):array {
            $invokeData = $this->fillData($partedUri, $invokeData);

            return $this->passToNext($partedUri, $invokeData);
        }

        /**
         * Works with give data and URI string array
         *
         * @param string[] $partedUri
         * @param string[] $invokeData
         * @return string[]
         */
        protected abstract function fillData(array $partedUri, array $invokeData = []):array;
    }