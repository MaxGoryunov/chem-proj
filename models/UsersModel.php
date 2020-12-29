<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\SelectQueryBuilder;
    use Entities\IEntity;
    use Entities\UserEntity;

    /**
     * Class containing Users business logic 
     */
    class UsersModel extends AbstractModel {

        /**
         * {@inheritDoc}
         */
        protected $tableName = "users";

        protected function getDomainName():string {
            return "user";
        }

        /**
         * {@inheritDoc}
         */
        protected function getDomainName():string {
            return "user";
        }

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
        public function edit(array $data = []):void {
            
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            
        }

        /**
         * Returns id of the user based on the login and password input
         *
         * @param string $login    - user's login
         * @param string $password - user's password
         * @return string[]
         */
        public function getUserInfoByRegistrationData(string $login, string $password):array {
            $connection = $this->connectToDB();
            $columns    = [
                "count" => "COUNT(`user_id`)",
                "user_id"
            ];

            $query      = (new SelectQueryBuilder($this->getTableName()))
                          ->what($columns)
                          ->whereAnd("`user_login` = '$login'")
                          ->whereAnd("`user_password` = '$password'")
                          ->build();

            $result   = $connection->query($query->getQueryString());
            $userInfo = $result->fetch_assoc();

			return $userInfo;
        }

        /**
         * Returns user salt which is used to safely store passwords in the Database
         *
         * @param string $email - user email from authorisation page
         * @return string
         */
        public function getSaltByUserEmail(string $email):string {
            $connection = $this->connectToDB();

            $query      = (new SelectQueryBuilder($this->getTableName()))
                          ->what(["user_salt"])
                          ->whereAnd("`user_email` = '$email'")
                          ->build();

            $result   = $connection->query($query->getQueryString());
            $userSalt = $result->fetch_assoc()["user_salt"];

			return $userSalt;
        }

        /**
         * Calculates number of registered users
         * 
         * This method is meant to protect Database from creating two accounts with the same login
         *
         * @param string $email
         * @return int
         */
        public function calculateRegisteredCount(string $email):int {
            $email = preg_quote($email);
            $connection = $this->connectToDB();
            $columns       = ["count" => "COUNT(`user_id`)"];

            $query       = (new SelectQueryBuilder($this->getTableName()))
                           ->what($columns)
                           ->whereAnd("`user_email` = '$email'")
                           ->build();

            $result = $connection->query($query->getQueryString());
            $count  = $result->fetch_assoc()["count"];
            
            return $count;
        }

        /**
         * Returns User's Admin Status based on User's SESSION
         *
         * @param int $userId
         * @return bool
         */
        public function getUserAdminStatus(int $userId = 0):bool {
            if ($userId == 0) {
                return false;
            }

            $connection = $this->connectToDB();
            $what       = ["user_is_admin"];

            $query      = (new SelectQueryBuilder($this->getTableName()))
                          ->what($what)
                          ->whereAnd("`user_id` = " . $userId)
                          ->build();

            $result      = $connection->query($query->getQueryString());
            $userIsAdmin = $result->fetch_assoc()["user_is_admin"];

            return (bool)$userIsAdmin;
        }

        /**
         * Deletes user variables from $_SESSION array
         *
         * @param array $session
         * @return void
         */
        public function deleteUserVariables(array &$session):void {
            unset($session["user_id"]);
            unset($session["token"]);
            unset($session["token_time"]);
        }
    }