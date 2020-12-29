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
        public function index():void {
            $title             = "Статусы пользователя";
            $fullUserStatus    = (new UsersFactory())->getModel()->getUserFullStatus();
            $userStatusesCount = $this->getModel()->calculateRecordCount();
            $currentPageNumber = $this->getModel()->getCurrentPageNumber();
            $limit             = 5;
            $offset            = ($currentPageNumber - 1) * $limit;
            $userStatusesList  = $this->getModel()->getList($limit, $offset);

            $viewData = array_merge($fullUserStatus, compact("title", "addressesList"));

            $this->getView()->render(__FUNCTION__, $viewData);
        }

        /**
         * {@inheritDoc}
         */
        public function edit(int $id):void {
            $title          = "Редактирование статуса пользователя";
            $userStatus     = $this->getModel()->getById($id);
			$fullUserStatus = (new UsersFactory())->getModel()->getUserFullStatus();
			
			if (isset($_POST["name"])) {
				$name = $_POST["name"];
                $data = compact("name", "id");
                
                $this->getModel()->edit($data);
            }
            
            $viewData = array_merge($fullUserStatus, compact("title", "userStatus"));
            
            $this->getView()->render(__FUNCTION__, $viewData);
        }

        /**
         * {@inheritDoc}
         */
        public function add():void {
            $title          = "Добавление статуса пользователя";
			$fullUserStatus = (new UsersFactory())->getModel()->getUserFullStatus();
			
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
            $fullUserStatus = (new UsersFactory())->getModel()->getUserFullStatus();

            if (isset($_POST["delete"])) {
                $this->getModel()->delete($id);
            }

			header('Location: ../list');
        }
    }