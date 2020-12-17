<?php

    namespace ControllerActions;

    use Controllers\IController;
    use Factories\AbstractFactory;

    /**
     * Base class for implementing other controller actions
     */
    abstract class AbstractAction {
        
        /**
         * Contains the factory object from which the Controller will be retrieved
         *
         * @var AbstractFactory
         */
        protected $factory;

        /**
         * @param AbstractFactory $factory
         */
        public function __construct(AbstractFactory $factory) {
            $this->factory = $factory;
        }
    }