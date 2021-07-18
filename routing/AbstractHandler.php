<?php

    namespace Routing;

use ControllerActions\ControllerAction;

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
         * {@inheritDoc}
         */
        public function handle(array $partedUri, ControllerAction $action):ControllerAction {
            $invokeData = $this->fillData($partedUri, $action);

            if (isset($this->nextHandler)) {
                return $this->nextHandler->handle($partedUri, $invokeData);
            }

            return $invokeData;
        }

        /**
         * Configures the given $action object
         *
         * @param string[] $partedUri      - URI string as array
         * @param ControllerAction $action - action to be configured
         * @return ControllerAction
         */
        protected abstract function fillData(array $partedUri, ControllerAction $action):ControllerAction;
    }
