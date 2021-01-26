<?php

    namespace ProxyControllers;

    use Controllers\AbstractController;
    use Factories\IMVCPDMFactory;
    use Factories\UsersFactory;
    use InvalidArgumentException;

    /**
     * Base class for implementing other ProxyControllers
     * 
     * @method void add()           Protects add action
     * @method void edit(int $id)   Protects edit action
     * @method void delete(int $id) Protects delete action
     */
    class CRUDProxyController {

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
         * @var AbstractController
         */
        private $relatedController;

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
        private function getController():AbstractController {
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
         * Magic method for invoking protected methods
         * 
         * @throws InvalidArgumentException if id is not supplied
         *
         * @param string $name     - name of protected method
         * @param int[] $arguments - method arguments
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