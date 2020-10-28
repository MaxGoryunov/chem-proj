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

        public function add():void {
            
        }

        public function edit(int $id):void {
            
        }

        public function delete(int $id):void {
            
        }
    }