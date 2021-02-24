<?php

    namespace ProxyControllers;

    use Controllers\AbstractController;
    use Controllers\IController;
    use Factories\IMVCPDMFactory;

    /**
     * Base class for implementing other ProxyControllers
     */
    abstract class AbstractProxyController {
        
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

        /**
         * Returns a related Controller from the same domain
         *
         * @return AbstractController
         */
        protected function getController():AbstractController {
            if (!isset($this->relatedController)) {
                $this->relatedController = $this->relatedFactory->getController();
            }

            return $this->relatedController;
        }
    }