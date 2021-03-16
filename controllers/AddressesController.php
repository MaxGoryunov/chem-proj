<?php

    namespace Controllers;

    use Factories\UsersFactory;

    /**
     * Class contains Address Controller logic
     */
    class AddressesController extends AbstractController {

        /**
         * {@inheritDoc}
         */
        protected function paramsList():array {
            return [
                "name" => "string"
            ];
        }

        /**
         * Controls the creation of an Address
         *
         * @return void
         */
        public function add():void {
            $title          = "Добавление адреса";
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
         * Controls the deletion process of an Address based on id
         *
         * @param int $id - id of the Address to be deleted
         * @return void
         */
        public function delete(int $id):void {
            $title = "Удаление адреса";
            $address = $this->getModel()->getById($id);
            $fullUserStatus = (new UsersFactory())->getModel()->getUserAdminStatus();

            if (isset($_POST["delete"])) {
                $this->getModel()->delete($id);
            }

			header('Location: ../list');
        }
    }