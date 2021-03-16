<?php

    namespace Controllers;

use Factories\UsersFactory;

/**
     * Class contains Gender Controller logic
     */
    class GendersController extends AbstractController {

        /**
         * {@inheritDoc}
         */
        protected function paramsList():array {
            return [
                "name"       => "string",
                "short_name" => "string"
            ];
        }

        /**
         * {@inheritDoc}
         */
        public function add():void {
            $title          = "Добавление гендера";
			$fullUserStatus = (new UsersFactory())->getModel()->getUserAdminStatus();
			
			if (isset($_POST["name"]) && (isset($_POST["short_name"]))) {
                $name       = $_POST["name"];
                $short_name = $_POST["short_name"];
                $data       = compact("name", "short_name");

                $this->getModel()->add($data);
			}

            $viewData = array_merge($fullUserStatus, compact("title"));
            
            $this->getView()->render(__FUNCTION__, $viewData);
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            $title          = "Удаление гендера";
            $gender         = $this->getModel()->getById($id);
            $fullUserStatus = (new UsersFactory())->getModel()->getUserAdminStatus();

            if (isset($_POST["delete"])) {
                $this->getModel()->delete($id);

                header("Location: ../list");
            }

            $viewData = array_merge($fullUserStatus, compact("title", $gender));

            $this->getView()->render(__FUNCTION__, $viewData);
        }
    }