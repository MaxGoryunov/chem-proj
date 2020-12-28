<?php

    namespace ControllerActions;

    use Controllers\IController;
    use Factories\AbstractFactory;
    use Factories\IControllerFactory;
    use Factories\IProxyFactory;

    /**
     * Base class for implementing other controller actions
     */
    abstract class AbstractAction {
        
        /**
         * Contains the factory object from which the Controller will be retrieved
         *
         * @var IControllerFactory
         */
        protected $factory;

        /**
         * @param AbstractFactory $factory
         */
        public function __construct(IControllerFactory $factory) {
            $this->factory = $factory;
        }

        /**
         * Returns a controller
         * 
         * if the factory can create controller proxy then it will be returned instead of the controller
         *
         * @return IController
         */
        protected function getController():IController {
            if ($this->factory instanceof IProxyFactory) {
                return $this->factory->getProxy();
            }

            return $this->factory->getController();
        }
    }