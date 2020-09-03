<?php

    /**
     * Base class for implementing other ProxyControllers
     */
    abstract class AbstractProxyController implements IController {
        
        /**
         * Related Factory used to get Controller from the same domain
         *
         * @var AbstractMVCPDMFactory
         */
        protected $relatedFactory;

        /**
         * Related Controller which is invoked(or not) after the Proxy Controller finishes its business
         *
         * @var AbstractController
         */
        protected $relatedController;

        /**
         * Accepts the Factory to delegate it the creation Related Controller
         *
         * @param IMVCPDMFactory $relatedFactory
         */
        public function __construct(IMVCPDMFactory $relatedFactory) {
            $this->relatedFactory = $relatedFactory;
        }
    }