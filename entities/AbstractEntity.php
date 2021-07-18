<?php

    namespace Entities;
    
    /**
     * Base class for implementing other Entities
     */
    abstract class AbstractEntity implements IEntity {
        
        /**
         * Unique id of object
         *
         * @var int
         */
        protected $id = 0;

        /**
         * Returns entity type
         *
         * @return string
         */
        protected abstract function getType():string;

        /**
         * Parses snake_case to camelCase
         *
         * @param string $propertyName
         * @return string
         */
        protected function snakeToCamelCase(string $propertyName):string {
            return lcfirst(str_replace(["_", $this->getType()], "", ucwords($propertyName, "_")));
        }

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
    }
