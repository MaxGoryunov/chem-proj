<?php

    namespace Controllers;

use Models\ConnectsModel;

class UsersController extends AbstractController {

        public function index():void {
            
        }

        public function edit(int $id):void {
            
        }

        public function add():void {
            
        }

        public function delete(int $id):void {
            
        }

        /**
         * Logs the user out of the system
         *
         * @return void
         */
        public function logout():void {
            $userId = $_SESSION["user_id"];

            $this->getModel()->deleteUserVariables($_SESSION);

            (new ConnectsModel())->delete($userId);

			header('Location: ../medicines/list');
        }
    }