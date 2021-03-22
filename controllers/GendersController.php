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