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
         * {@inheritDoc}
         */
        protected function getType():string {
            return "User";
        }
    }