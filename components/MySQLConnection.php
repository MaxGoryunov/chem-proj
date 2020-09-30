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
         * Returns the MySQL Database connection
         * 
         * @throws Exception if the connection to MySQL has failed
         *
         * @return mysqli
         */
        public function getConnection():mysqli {
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

            return self::$connection;
        }

        /**
         * Returns the result of MySQLi query
         *
         * @param Query $query
         * @return mysqli_result|bool
         */
        public function query(Query $query) {
            return self::$connection->query($query->getQueryString());
        }

        /**
         * Returns all matched rows from DB Table
         *
         * @param Query $query
         * @param int $resultType
         * @return array
         */
        public function fetchAll(Query $query, int $resultType = MYSQLI_ASSOC):array {
            $result  = $this->query($query);
            $fetchAll = $result->fetch_all($resultType);

            return $fetchAll;
        }

        /**
         * Returns a single matched row from DB Table
         *
         * @param Query $query
         * @return array
         */
        public function fetchAssoc(Query $query):array {
            $result = $this->query($query);
            $fetchAssoc = $result->fetch_assoc();

            return $fetchAssoc ?? [];
        }

    }