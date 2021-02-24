<?php

    namespace Entities;
    
    /**
     * Database Address Entity
     */
    class AddressEntity extends AbstractEntity {

        /**
         * Name of the Address
         *
         * @var string
         */
        public $name = "";

        /**
         * Stores the deletion state of the Address
         *
         * @var int
         */
        public $isDeleted = 0;

        /**
         * {@inheritDoc}
         */
        protected function getType():string {
            return "Address";
        }
    }