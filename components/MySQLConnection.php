<?php

    /**
     * Class which represents connection with MySQL Database
     * 
     * This class implements Singleton Pattern
     */
    class MySQLConnection implements IDBConnection {
        /**
         * Singleton instance
         *
         * @static
         * 
         * @var self|null
         */
        private static $instance = null;

        /**
         * Connection to MySQL Database
         *
         * @var mysqli|null
         */
        private $connection = null;

        /**
         * Function returns the instance of the class which uses this trait
         *
         * @static
         * 
         * @return self
         */
        public static function getInstance():self {
            if (!self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Restricting the creation of class instance outside of class
         * 
         * @throws Exception if the connection to MySQL failed
         */
        private function __construct() {
            include_once("./config/dbConfig.php");

            /**
             * Establishing the connection with MySQL Database
             */
            $connection = new mysqli($dbConfig["host"], $dbConfig["user"], $dbConfig["password"], $dbConfig["database"]);

            if ($connection->connect_error) {
                throw new Exception("Failed to connect to MySQL database: " . $connection->connect_errno);
            }

            $connection->set_charset($dbConfig["charset"]);

            $this->connection = $connection;

            return;
        }

        /**
         * Returns the MySQL Database connection
         *
         * @return mysqli
         */
        public function getConnection():mysqli {
            return $this->connection;
        }

        /**
         * Restricting cloning
         */
        private function __clone() {

        }

        /**
         * Restricting serialization
         */
        private function __wakeup() {

        }

        /**
         * Restricting deserialization
         */
        private function __sleep() {

        }
    }