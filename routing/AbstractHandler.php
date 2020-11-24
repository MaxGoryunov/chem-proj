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

    }