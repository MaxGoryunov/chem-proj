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
         * Simple magic setter for all properties
         * 
         * Property names are first converted from snake_case to camelCase and then if such property exists then it is set
         *
         * @param string $name
         * @param mixed $value
         */
        public function __set(string $name, $value) {
            $name = $this->snakeToCamelCase($name);

            if (property_exists($this, $name)) {
                $this->$name = $value;
            }
        }

        /**
         * Returns class property
         *
         * @param string $name
         * @return mixed
         */
        public function __get(string $name) {
            $name = $this->snakeToCamelCase($name);

            if (property_exists($this, $name)) {
                return $this->$name;
            }
        }

        /**
         * Parses snake_case to camelCase
         *
         * @param string $propertyName
         * @return string
         */
        private function snakeToCamelCase(string $propertyName):string {
            return lcfirst(str_replace(["_", "UserStatus"], "", ucwords($propertyName, "_")));
        }
    }