<?php

    namespace ProxyControllers;

    use Factories\UsersFactory;

    /**
     * Class which replaces GendersController on class calls
     */
    class GendersProxyController extends AbstractProxyController {

        /**
         * {@inheritDoc}
         */
        public function add():void {
            $userAdminStatus = (new UsersFactory())->getModel()->getUserAdminStatus();

            if ($userAdminStatus) {
                $this->getController()->add();
            }
        }

        /**
         * {@inheritDoc}
         */
        public function edit(int $id):void {
            $userAdminStatus = (new UsersFactory())->getModel()->getUserAdminStatus();

            if ($userAdminStatus) {
                $this->getController()->edit($id);
            }
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            $userAdminStatus = (new UsersFactory())->getModel()->getUserAdminStatus();

            if ($userAdminStatus) {
                $this->getController()->delete($id);
            }
        }
    }