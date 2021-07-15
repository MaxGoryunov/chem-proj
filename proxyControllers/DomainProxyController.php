<?php

    namespace ProxyControllers;

    use Controllers\DomainController;
use Controllers\IController;
use Factories\DomainFactory;
    use Factories\UsersFactory;
    use InvalidArgumentException;

    /**
     * Base class for implementing other ProxyControllers
     */
    class DomainProxyController implements IController {

        /**
         * Protected controller methods
         * 
         * True means that id is required to call this method, false means that id is not required
         * 
         * @var bool[]
         */
        private const PROTECTED_METHODS = [
            "add"    => false,
            "edit"   => true,
            "delete" => true
        ];
        
        /**
         * Related Factory used to get Controller from the same domain
         *
         * @var AbstractMVCPDMFactory
         */
        private $relatedFactory;

        /**
         * Related Controller which is invoked(or not) after the Proxy Controller finishes its business
         *
         * @var DomainController
         */
        private $relatedController;

        /**
         * Accepts the Factory to delegate it the creation Related Controller
         *
         * @param DomainFactory $relatedFactory
         */
        public function __construct(DomainFactory $relatedFactory) {
            $this->relatedFactory = $relatedFactory;
        }

        /**
         * Returns a related Controller from the same domain
         *
         * @return DomainController
         */
        private function getController():DomainController {
            if (!isset($this->relatedController)) {
                $this->relatedController = $this->relatedFactory->getController();
            }

            return $this->relatedController;
        }

        /**
         * Invokes the index action
         * 
         * @return void
         */
        public function index():void {
            $this->getController()->index();
        }

        /**
         * {@inheritDoc}
         */
        public function add(): void
        {
            if ((new UsersFactory())->getModel()->getUserAdminStatus($_COOKIE["id"])) {
                $this->getController()->add();
            } else {
                throw new 
            }
        }

        /**
         * Magic method for invoking protected methods
         * 
         * @throws InvalidArgumentException if id is not supplied
         *
         * @param string $name     - name of protected method
         * @param int[]  $arguments - method arguments
         * @return void
         */
        public function __call(string $name, array $arguments):void {
            if (empty(self::PROTECTED_METHODS[$name])) return;

            $userAdminStatus = (new UsersFactory())->getModel()->getUserAdminStatus();

            /**
             * @todo Implement error routing
             */
            if (!$userAdminStatus) return;

            $idRequired = self::PROTECTED_METHODS[$name];
            [$id]       = $arguments;

            if ($id) {
                $this->getController()->$name($id);
            } elseif ($idRequired) {
                throw new InvalidArgumentException("Id must be supplied");
            }
        }
    }