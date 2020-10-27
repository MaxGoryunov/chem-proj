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

        public function edit(int $id):void {
            
        }

        public function add():void {
            
        }

        public function delete(int $id):void {
            
        }
    }