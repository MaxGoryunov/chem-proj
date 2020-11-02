<?php

    namespace ProxyControllers;

use Factories\UsersFactory;

/**
     * Proxy Controller for actions related to addresses
     */
    class AddressesProxyController extends AbstractProxyController {
        
        /**
         * Controls the presentation of Addresses from DB
         * 
         * @return void
         */
        public function index():void {
            $this->getController()->index();
        }

        /**
         * Controls the editing process of an Address based on id
         *
         * @param int $id - id of the Addresses
         * @return void
         */
        public function edit(int $id):void {
            $userAdminStatus = (new UsersFactory())->getModel()->getUserAdminStatus();

            if ($userAdminStatus) {
                $this->getController()->edit($id);
            }
        }

        /**
         * Controls the creation of an Address
         *
         * @return void
         */
        public function add():void {
            
        }

        /**
         * Controls the deletion of an Address based on id
         *
         * @param int $id - id of an Address
         * @return void
         */
        public function delete(int $id):void {
            
        }
    }