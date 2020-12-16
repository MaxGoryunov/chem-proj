<?php

    namespace Entities;
    
    /**
     * Database Gender Entity
     */
    class GenderEntity extends AbstractEntity {

        /**
         * Name of the Gender
         *
         * @var string
         */
        private $name = "";

        /**
         * Short name of the Gender
         *
         * @var string
         */
        private $shortName = "";

        /**
         * Stores the deletion state of the Gender
         *
         * @var string
         */
        private $isDeleted = "";

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
            return lcfirst(str_replace(["_", "Gender"], "", ucwords($propertyName, "_")));
        }
    }