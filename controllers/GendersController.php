<?php

    namespace Controllers;

use Factories\UsersFactory;

/**
     * Class contains Gender Controller logic
     */
    class GendersController extends AbstractController {
        
        /**
         * Controls the presentation process of the Genders from the DB
         *
         * @return void
         */
        public function index():void {
            $title             = "Гендеры";
            $fullUserStatus    = (new UsersFactory())->getModel()->getUserFullStatus();
            $gendersCount      = $this->getModel()->calculateRecordCount();
            $currentPageNumber = $this->getModel()->getCurrentPageNumber();
            $limit             = 5;
            $offset            = ($currentPageNumber - 1) * $limit;
            $gendersList       = $this->getModel()->getList($limit, $offset);

            $viewData = array_merge($fullUserStatus, compact("title", "gendersList"));

            $this->getView()->render(__FUNCTION__, $viewData);
        }

        /**
         * {@inheritDoc}
         */
        public function edit(int $id):void {
            $title          = "Редактирование гендера";
			$gender         = $this->getModel()->getById($id);
            $fullUserStatus = (new UsersFactory())->getModel()->getUserFullStatus();

			if ((isset($_POST["name"])) && (isset($_POST["short_name"]))) {
                $name       = $_POST["name"];
                $short_name = $_POST["short_name"];
                $data       = compact("name", "short_name", "id");
                
                $this->getModel()->edit($data);
			}

            $viewData = array_merge($fullUserStatus, compact("title", "gender"));

			$this->getView()->render(__FUNCTION__, $viewData);
        }

        /**
         * {@inheritDoc}
         */
        public function add():void {
            $title          = "Добавление гендера";
			$fullUserStatus = (new UsersFactory())->getModel()->getUserFullStatus();
			
			if (isset($_POST["name"]) && (isset($_POST["short_name"]))) {
                $name       = $_POST["name"];
                $short_name = $_POST["short_name"];
                $data       = compact("name", "short_name");

                $this->getModel()->add($data);
			}

            $viewData = array_merge($fullUserStatus, compact("title"));
            
            $this->getView()->render(__FUNCTION__, $viewData);
        }

        public function delete(int $id):void {
            
        }
    }