<?php

    namespace ControllerActions;

    use Controllers\IController;
    use Factories\IControllerFactory;
    use Factories\IProxyFactory;
    use InvalidArgumentException;
    use LogicException;

    /**
     * Base class for implementing other controller actions
     */
    class ControllerAction {

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
         * Contains the factory object from which the Controller will be retrieved
         *
         * @var IControllerFactory
         */
        private $factory;

        /**
         * name of the action which is executed
         *
         * @var string
         */
        private $actionName = "";

        /**
         * Data for controller action
         *
         * @var array<string, mixed>
         */
        private $data = [];

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
         * Sets factory used to get the controller
         *
         * @param IControllerFactory $factory
         * @return void
         */
        public function setFactory(IControllerFactory $factory) {
            $this->factory = $factory;
        }

        /**
         * Sets Action name
         *
         * @throws InvalidArgumentException if the action name is of invalid type
         * 
         * @param string $actionName
         * @return void
         */
        public function setActionName(string $actionName):void {
            if (isset(self::ACTIONS[$actionName])) {
                $this->actionName = $actionName;
            } else {
                throw new InvalidArgumentException("Action must be of valid type");
            }
        }

        /**
         * Adds controller data
         *
         * @param string $name - new data value name
         * @param mixed $value - value itself
         * @return void
         */
        public function addData(string $name, mixed $value):void {
            $this->data[$name] = $value;
        }

        /**
         * Returns controller factory
         *
         * @return IControllerFactory
         */
        public function getFactory():IControllerFactory {
            return $this->factory;
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
         * Returns controller data
         *
         * @return array
         */
        public function getData():array {
            return $this->data;
        }

        /**
         * Executers controller method
         * 
         * @throws LogicException if the id is not present when needed
         *
         * @return void
         */
        public function execute():void {
            $controller = $this->getController();

            /**
             * @todo Add support for more arguments
             * 
             * @todo Replace if with DataValidator method
             */
            if (self::ACTIONS[$this->getActionName()]) {
                if (isset($this->data["id"])) {
                    $controller->{$this->getActionName()}($this->data["id"]);
                } else {
                    throw new LogicException("id is needed to perform this action");
                }
            } else {
                $controller->{$this->getActionName()}();
            }
        }
    }
