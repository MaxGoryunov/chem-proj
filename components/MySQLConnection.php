<?php

    namespace Components;

    use DBQueries\Query;
    use Exception;
    use mysqli;
    use mysqli_result;
    use mysqli_sql_exception;

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
         * @todo Make method public and change its test
         *
         * @param string[] $config
         * @return mysqli
         */
        private function establishConnection(array $config):mysqli {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            try {
                $connection = new mysqli($config["host"], $config["user"], $config["password"], $config["database"]);

                $connection->set_charset($config["charset"]);
            } catch (mysqli_sql_exception $e) {
                $this->fail($e);
            }

            return $connection;
        }

        /**
         * Throws a new sql exception
         * 
         * @throws mysqli_sql_exception
         *
         * @param mysqli_sql_exception $e
         * @return void
         */
        public function fail(mysqli_sql_exception $e):void {
            throw new mysqli_sql_exception($e->getMessage(), $e->getCode());
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
        public function fetchAssoc(Query $query, string $alias = "") {
            $result = $this->query($query);
            /**
             * If the alias is not an empty string then it is used as a key, otherwise it is not used
             */
            $fetchAssoc = ($alias === "") ? $result->fetch_assoc() : $result->fetch_assoc()[$alias];

            return $fetchAssoc ?? [];
        }

    }