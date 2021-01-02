<?php

    namespace ControllerActions;

    use Controllers\IController;
    use Factories\AbstractFactory;
    use Factories\IControllerFactory;
    use Factories\IProxyFactory;
    use InvalidArgumentException;
    use LogicException;

    /**
     * Base class for implementing other controller actions
     */
    class AbstractAction {

        /**
         * Contains allowed actions in relation to the need of id to perform the action
         * 
         * If the value is true then id is needed to perform the action, otherwise the action is performed without the id
         * 
         * @var bool[]
         */
        private const ACTIONS = [
            "index"    => false,
            "add"      => false,
            "edit"     => true,
            "delete"   => true,
            "register" => false
        ];

        /**
         * name of the action which is executed
         *
         * @var string
         */
        protected $actionName;
        
        /**
         * Contains the factory object from which the Controller will be retrieved
         *
         * @var IControllerFactory
         */
        protected $factory;

        /**
         * @throws InvalidArgumentException if the action name is of invalid type
         * 
         * @param AbstractFactory $factory
         */
        public function __construct(IControllerFactory $factory, string $actionName) {
            $this->factory    = $factory;

            if (isset(self::ACTIONS[$actionName])) {
                $this->actionName = $actionName;
            } else {
                throw new InvalidArgumentException("Action must be of valid type");
            }
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

        /**
         * Returns action name
         *
         * @return string
         */
        public function getActionName():string {
            return $this->actionName;
        }

        /**
         * Executers controller method
         * 
         * @throws LogicException if the id is not present when needed
         *
         * @param int $id - id for the action, might not be needed
         * @return void
         */
        public function execute(int $id = null):void {
            $controller = $this->getController();

            if (self::ACTIONS[$this->getActionName()]) {
                if ($id) {
                    $controller->{$this->getActionName()}($id);
                } else {
                    throw new LogicException("id is needed to perform this action");
                }
            } else {
                $controller->{$this->getActionName()}();
            }
        }
    }