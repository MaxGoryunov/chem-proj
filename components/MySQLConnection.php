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
         * @throws Exception if the connection to the Database failed
         */
        public function __construct() {
            if (!self::$connection) {
                include_once("./config/dbConfig.php");

                /**
                 * Establishing the connection with MySQL Database
                 */
                $connection = new mysqli($dbConfig["host"], $dbConfig["user"], $dbConfig["password"], $dbConfig["database"]);

                if ($connection->connect_error) {
                    throw new Exception("Failed to connect to MySQL database: " . $connection->connect_errno);
                }

                $connection->set_charset($dbConfig["charset"]);

                self::$connection = $connection;
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
            $result  = $this->query($query);
            $fetchAll = $result->fetch_all($resultType);

            return $fetchAll;
        }

        /**
         * {@inheritDoc}
         */
        public function fetchAssoc(Query $query, string $alias = ""):array {
            $result     = $this->query($query);
            /**
             * If the alias is not an empty string then it is used as a key, otherwise it is not used
             */
            $fetchAssoc = ($alias === "") ? $result->fetch_assoc() : $result->fetch_assoc()[$alias];

            return $fetchAssoc ?? [];
        }

    }