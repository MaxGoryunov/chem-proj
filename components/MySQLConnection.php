<?php

    namespace Components;

    use DBQueries\Query;
    use Exception;
    use mysqli;
    use mysqli_result;

    /**
     * Class which represents connection with MySQL Database
     * 
     * This class implements Singleton Pattern
     */
    class MySQLConnection implements IDBConnection {

        /**
         * Connection to MySQL Database
         *
         * @var mysqli
         */
        private static $connection = null;

        /**
         * Sets up a common MySQL connection if it has not been set up yet
         */
        public function __construct() {
            if (!self::$connection) {
                self::$connection = $this->establishConnection(include_once("./config/dbConfig.php"));
            }
        }

        /**
         * Connects to MySQL Database
         *
         * @param string[] $config
         * @return mysqli
         */
        private function establishConnection(array $config):mysqli {
            $connection = new mysqli($config["host"], $config["user"], $config["password"], $config["database"]);

            $this->validateConnection($connection);
            $connection->set_charset($config["charset"]);

            return $connection;
        }

        /**
         * Validates MySQL connection
         * 
         * @codeCoverageIgnore
         * @throws Exception if the connection to the Database failed
         *
         * @param mysqli $connection
         * @return void
         */
        public function validateConnection(mysqli $connection):void {
            if ($connection->connect_error) {
                throw new Exception("Failed to connect to MySQL database: " . $connection->connect_errno);
            }
        }

        /**
         * Performs a MySQLi query to Database
         *
         * @param Query $query
         * @return mysqli_result|bool
         */
        public function query(Query $query) {
            return self::$connection->query($query->getQueryString());
        }

        /**
         * {@inheritDoc}
         */
        public function fetchAll(Query $query, int $resultType = MYSQLI_ASSOC):array {
            $result   = $this->query($query);
            $fetchAll = $result->fetch_all($resultType);

            return $fetchAll;
        }

        /**
         * {@inheritDoc}
         */
        public function fetchAssoc(Query $query, string $alias = ""):array {
            $result = $this->query($query);
            /**
             * If the alias is not an empty string then it is used as a key, otherwise it is not used
             */
            $fetchAssoc = ($alias === "") ? $result->fetch_assoc() : $result->fetch_assoc()[$alias];

            return $fetchAssoc ?? [];
        }

    }