<?php

    namespace Entities;
    
    /**
     * Database User Entity
     */
    class UserEntity implements IEntity {
        
        /**
         * User name
         *
         * @var string
         */
        public $name = "";

        /**
         * User surname
         *
         * @var string
         */
        public $surname = "";

        /**
         * User login
         *
         * @var string
         */
        public $login = "";

        /**
         * User password
         *
         * @var string
         */
        public $password = "";

        /**
         * User email
         *
         * @var string
         */
        public $email = "";

        /**
         * User Address id
         *
         * @var string|int
         */
        public $addressId;

        /**
         * User Address Entity
         *
         * @var AddressEntity
         */
        public $address;

        /**
         * User Gender id
         *
         * @var string|int
         */
        public $genderId;

        /**
         * User Gender Entity
         *
         * @var GenderEntity
         */
        public $gender;

        /**
         * User User Status id
         *
         * @var string|int
         */
        public $userStatusId;

        /**
         * User User Status Entity
         *
         * @var UserStatusEntity
         */
        public $userStatus;

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
            return lcfirst(str_replace(["_", "Address"], "", ucwords($propertyName, "_")));
        }
    }