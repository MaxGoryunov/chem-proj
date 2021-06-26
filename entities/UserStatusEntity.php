<?php

    namespace Entities;
    
    /**
     * Database User Status Entity
     */
    class UserStatusEntity extends AbstractEntity {

        /**
         * Name of the User Status
         *
         * @var string
         */
        public $name = "";

        /**
         * Stores the deletion state of the User Status
         *
         * @var string
         */
        public $isDeleted = "";

        /**
         * {@inheritDoc}
         */
        protected function getType():string {
            return "UserStatus";
        }
    }