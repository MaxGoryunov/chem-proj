<?php

    namespace Entities;
    
    /**
     * Database Address Entity
     */
    class AddressEntity extends AbstractEntity {

        /**
         * Contains the mappings for ORM
         * 
         * @var string[]
         */
        private const MAPS = [
            "address_id"         => "id",
            "address_name"       => "name",
            "address_is_deleted" => "isDeleted"
        ];

        /**
         * Name of the Address
         *
         * @var string
         */
        private $name;

        /**
         * Stores the deletion state of the Address
         *
         * @var string
         */
        private $isDeleted;

        /**
         * Returns the property if it exists
         *
         * @param string $name
         * @return mixed
         */
        public function __get(string $name) {
            if (isset($this->$name)) {
                return $this->name;
            }

            $property = self::MAPS[$name] ?? null;

            if (isset($property)) {
                return $this->$property;
            }

            return null;
        }

        /**
         * Sets the property from the Query result
         *
         * @param string $name
         * @param mixed $value
         */
        public function __set(string $name, $value) {
            $property = self::MAPS[$name] ?? null;

            /**
             * The property can be set only once during instantiation. Might be changed later
             */
            if ((isset($property)) && (!isset($this->$property))) {
                $this->$property = $value;
            }
        }
    }