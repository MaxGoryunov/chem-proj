<?php

    namespace Controllers;

    use Factories\UsersFactory;

    /**
     * Class contains User Status Controller logic
     */
    class UserStatusesController extends AbstractController {

        /**
         * {@inheritDoc}
         */
        protected function paramsList():array {
            return [
                "name" => "string"
            ];
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            $title          = "Удаление статуса пользователя";
            $userStatus     = $this->getModel()->getById($id);
            $fullUserStatus = (new UsersFactory())->getModel()->getUserAdminStatus();

            if (isset($_POST["delete"])) {
                $this->getModel()->delete($id);
            }

			header('Location: ../list');
        }
    }