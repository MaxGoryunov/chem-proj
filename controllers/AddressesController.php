<?php

    /**
     * Class contains Address Controller logic
     */
    class AddressesController extends AbstractController {
        
        /**
         * Controls the presentation process of the Addresses from the DB
         *
         * @return void
         */
        public function index():void {
            $title             = "Адреса";
            $fullUserStatus    = (new UsersFactory())->getModel()->getUserFullStatus();
            $addressesCount    = $this->getModel()->calculateRecordCount();
            $currentPageNumber = $this->getModel()->getCurrentPageNumber();
            $limit             = 5;
            $offset            = ($currentPageNumber - 1) * $limit;
            $addressesList     = $this->getModel()->getList($limit, $offset);

            $viewData = array_merge($fullUserStatus, compact("title", "addressesList"));

            $this->getView()->render(__METHOD__, $viewData);
        }

        /**
         * Controls the editing process of an Address based on id
         *
         * @param int $id - id of the Address to be edited
         * @return void
         */
        public function edit(int $id):void {

        }

        /**
         * Controls the creation of an Address
         *
         * @return void
         */
        public function add():void {

        }

        /**
         * Controls the deletion process of an Address based on id
         *
         * @param int $id - id of the Address to be deleted
         * @return void
         */
        public function delete(int $id):void {

        }
    }