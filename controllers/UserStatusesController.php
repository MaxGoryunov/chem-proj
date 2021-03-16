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
        public function add():void {
            $title          = "Добавление статуса пользователя";
			$fullUserStatus = (new UsersFactory())->getModel()->getUserAdminStatus();
			
			if (isset($_POST["name"])) {
				$name = $_POST["name"];
                $data = compact("name");

                $this->getModel()->add($data);
			}

            $viewData = array_merge($fullUserStatus, compact("title"));
            
			$this->getView()->render(__FUNCTION__, $viewData);
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