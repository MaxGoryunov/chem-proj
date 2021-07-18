<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use Components\TokenGenerator;
    use DBQueries\InsertQueryBuilder;
    use DBQueries\SelectQueryBuilder;
    use Entities\IEntity;
    use Entities\UserEntity;
    use mysqli;

    /**
     * Class containing Users business logic 
     */
    class UsersModel extends DomainModel {

        /**
         * {@inheritDoc}
         */
        protected $tableName = "users";

        /**
         * Errors from view forms
         *
         * @var array<string, string>
         */
        private $errors = [];

        /**
         * {@inheritDoc}
         */
        protected function getDomainName():string {
            return "user";
        }

        /**
         * Returns an error related to a specified field
         *
         * @param string $field
         * @return string
         */
        public function getError(string $field):string {
            return $this->errors[$field];
        }

        /**
         * Returns all stored errors
         *
         * @return array<string. string>
         */
        public function getErrors():array {
            return $this->errors;
        }

        /**
         * {@inheritDoc}
         * @return UserEntity[]
         */
        public function getList(int $limit, string $uri):array {
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
         * 
         * @return mysqli
         */
        public function add(array $data = []):void {
            $connection       = DBConnectionProvider::getConnection(IDBConnection::class);
            $data["salt"]     = (new TokenGenerator())->generateToken();
            $data["password"] = md5($data["salt"] . $data["password"]);

            $query      = (new InsertQueryBuilder($this->getTableName()))
                          ->set($data)
                          ->build();

            $connection->query($query->getQueryString());

            // return $connection;
        }

        /**
         * {@inheritDoc}
         */
        public function edit(array $data = [], int $id):void {
            
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            
        }

        /**
         * Returns id of the user based on the login and password input
         *
         * @param string $email    - user's email
         * @param string $password - user's password
         * @return string[]
         */
        public function getUserInfoByRegistrationData(string $login, string $password):array {
            $connection = $this->connectToDB();
            $columns    = [
                "count" => "COUNT(`user_id`)",
                "user_id"
            ];

            $salt           = $this->getSaltByUserEmail($email);
            $hashedPassword = md5($salt . $password);

            $query      = (new SelectQueryBuilder($this->getTableName()))
                          ->what($columns)
                          ->whereAnd("`user_email` = '$email'")
                          ->whereAnd("`user_password` = '$hashedPassword'")
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
            return $this->connectToDB()->query(
                (new SelectQueryBuilder(
                    $this, 
                    ["count" => "COUNT(`user_id`)"]
                ))->where(
                    join("", ["`user_email` = '", preg_quote($email), "'"])
                )
            )->fetch_assoc()["count"];
        }

        /**
         * Returns User's Admin Status based on User's SESSION
         *
         * @param int $userId
         * @return bool
         */
        public function getUserAdminStatus(int $userId = 0):bool {
            if ($userId === 0) {
                return false;
            }
            return (bool)$this->connectToDB()->query(
                (new SelectQueryBuilder(
                    $this,
                    ["user_is_admin"]
                ))->where("`user_id` = " . $userId)
            )->fetch_assoc()["user_is_admin"];
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

        /**
         * Returns a random user salt
         *
         * @return string
         */
        public function getSalt():string {
            return (new TokenGenerator())->generateToken();
        }

        /**
         * Returns a hashed salted password
         *
         * @param string $password - user password
         * @param string $salt     - random user salt
         * @return string
         */
        public function hashPassword(string $password, string $salt):string {
            return md5($password . $salt);
        }

        /**
         * Returns a unique user token
         *
         * @return string
         */
        public function generateUserToken():string {
            return (new TokenGenerator())->generateToken();
        }

        /**
         * Adds a new error message
         * 
         * Error messages are later displayed in the view forms
         *
         * @param string $field   - input field in which the error occurred
         * @param string $message - error message for the user to read
         * @return void
         */
        public function addInputError(string $field, string $message):void {
            $this->errors[$field] = $message;
        }
    }
