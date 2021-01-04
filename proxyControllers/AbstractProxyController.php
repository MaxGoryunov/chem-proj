<?php

    namespace ProxyControllers;

    use Controllers\AbstractController;
    use Controllers\IController;
    use Factories\IMVCPDMFactory;
    use Factories\UsersFactory;

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

        /**
         * Invokes the index action
         * 
         * @return void
         */
        public function index():void {
            $this->getController()->index();
        }

        /**
         * Protects add action
         *
         * @return void
         */
        public function add():void {
            /**
             * @todo Add a method to get user status
             */
            $userAdminStatus = (new UsersFactory())->getModel()->getUserAdminStatus();

            if ($userAdminStatus) {
                $this->getController()->add();
            }
        }

        /**
         * Protects edit action
         *
         * @param int $id
         * @return void
         */
        public function edit(int $id):void {
            $userAdminStatus = (new UsersFactory())->getModel()->getUserAdminStatus();

            if ($userAdminStatus) {
                $this->getController()->edit($id);
            }
        }

        /**
         * Protects delete action
         *
         * @param int $id
         * @return void
         */
        public function delete(int $id):void {
            $userAdminStatus = (new UsersFactory())->getModel()->getUserAdminStatus();

            if ($userAdminStatus) {
                $this->getController()->delete($id);
            }
        }
    }