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
        private $name = "";

        /**
         * Stores the deletion state of the Address
         *
         * @var bool
         */
        private $isDeleted = false;

        /**
         * Sets up a new Address
         *
         * @param int $id
         * @param string $name
         */
        public function __construct(int $id, string $name) {
            $this->id   = $id;
            $this->name = $name;
        }

        /**
         * Returns name of the Address
         *
         * @return string
         */
        public function getName():string {
            return $this->name;
        }

        /**
         * Returns the deletion state of the Address
         *
         * @return bool
         */
        public function getIsDeleted():bool {
            return $this->isDeleted;
        }
    }