<?php

    /**
     * Class containing Users business logic 
     */
    class UsersModel extends AbstractModel {

        /**
         * {@inheritDoc}
         */
        protected $tableName = "users";

        /**
         * {@inheritDoc}
         * @return UserEntity[]
         */
        public function getList(int $limit, int $offset):array {
            return [];
        }

        /**
         * {@inheritDoc}
         * @return UserEntity
         */
        public function getById(int $id):IEntity {
            return new UserEntity();
        }

        /**
         * {@inheritDoc}
         */
        public function add(array $data = []):void {
            
        }

        /**
         * {@inheritDoc}
         */
        public function edit(array $data = []):void {
            
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            
        }

        /**
         * @todo Implement a stricter and safer version of the method with SESSION instead of COOKIE
         */
        /**
         * @todo Implement a complete version of the method
         */
        /**
         * Returns User's Admin Status based on User's COOKIE
         *
         * @return boolean
         */
        public function getUserAdminStatus():bool {
            return false;
        }

        /**
         * @todo Implement a stricter and safer version of the method with SESSION instead of COOKIE
         */
        /**
         * @todo Implement a complete version of the method
         */
        /**
         * Returns User's Authorisation Status based on User's COOKIE
         *
         * @return boolean
         */
        public function getUserAuthStatus():bool {
            return true;
        }

        /**
         * Returns User's Authorisation and Admin Status based on User's COOKIE
         *
         * @return bool[]
         */
        public function getUserFullStatus():array {
            return [
                "userIsAdmin" => $this->getUserAdminStatus(),
                "userIsAuthorised" => $this->getUserAuthStatus()
            ];
        }
    }