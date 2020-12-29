<?php

    namespace ProxyControllers;

    use Factories\UsersFactory;

    /**
     * Proxy Controller for actions related to User Statuses
     */
    class UserStatusesProxyController extends AbstractProxyController {

        /**
         * Protects the edit action
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
         * Protects the add action
         *
         * @return void
         */
        public function add():void {
            $userAdminStatus = (new UsersFactory())->getModel()->getUserAdminStatus();

            if ($userAdminStatus) {
                $this->getController()->add();
            }
        }

        /**
         * Protects the delete action
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