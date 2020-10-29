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

    }