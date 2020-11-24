<?php

    namespace Routing;

    /**
     * Interface for routing handlers which extract different parts of user URI
     */
    interface IRoutingHandler {
        
        /**
         * Sets the next handler in a chain of responsibility
         * 
         * Method returns the supplied handler so that the assignment can be chained
         *
         * @param IRoutingHandler $nextHandler
         * @return IRoutingHandler
         */
        public function setNextHandler(IRoutingHandler $nextHandler):IRoutingHandler;

        /**
         * Handles the extraction of a part of user URI and sends the request down the CoR
         *
         * @param string[] $partedUri  - URI string as an array
         * @param string[] $invokeData - data for Router method
         * @return string[]
         */
        public function handle(array $partedUri, array $invokeData = []):array;
    }