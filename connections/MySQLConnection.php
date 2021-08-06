<?php

    namespace Components;

use Connections\BaseResult;
use Connections\Result;
use DBQueries\IQueryBuilder;
    use mysqli;
    use mysqli_result;
    use mysqli_sql_exception;

    /**
     * Class which represents connection with MySQL Database
     * 
     * This class implements Singleton Pattern
     */
    class MySQLConnection implements Connection {

        /**
         * Connection to MySQL Database
         *
         * @var mysqli
         */
        private mysqli $connection;

        /**
         * Ctor.
         * 
         * @param Result $result
         */
        public function __construct(Result $result) {
            $this->connection = $this->establishConnection(
                include("./config/dbConfig.php")
            );
        }

        /**
         * Connects to MySQL Database
         * 
         * @todo Make method public and change its test
         *
         * @param string[] $config
         * @return mysqli
         */
        public function establishConnection(array $config):mysqli {
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
         * {@inheritDoc}
         */
        public function query(IQueryBuilder $builder): Result {
            return new BaseResult(
                $this->connection->query($builder->build()->getQueryString()),
                [
                    "fetchAll"     => "fetch_all",
                    "fetchAssoc"   => "fetch_assoc",
                    "fetchObject"  => "fetch_object",
                    "fetchObjects" => "fetch_objects"
                ]
            );
        }

        // /**
        //  * {@inheritDoc}
        //  */
        // public function fetchAll(IQueryBuilder $builder, int $resultType = MYSQLI_ASSOC):array {
        //     return $this->query($builder)->fetch_all($resultType);
        // }

        // /**
        //  * {@inheritDoc}
        //  */
        // public function fetchAssoc(IQueryBuilder $builder, string $alias = "") {
        //     $result = $this->query($builder);
        //     /**
        //      * If the alias is not an empty string then it is used as a key, otherwise it is not used
        //      * 
        //      * @todo Divide method into method without alias and method with alias
        //      */
        //     $fetchAssoc = ($alias === "") ? $result->fetch_assoc() : $result->fetch_assoc()[$alias];

        //     return $fetchAssoc ?? [];
        // }

        // /**
        //  * {@inheritDoc}
        //  */
        // public function fetchObject(IQueryBuilder $builder, string $className):object {
        //     return $this->query($builder)->fetch_object($className);
        // }

        // /**
        //  * {@inheritDoc}
        //  */
        // public function fetchObjects(IQueryBuilder $builder, string $className):array {
        //     $result  = $this->query($builder);
        //     $objects = [];

        //     while ($object = $result->fetch_object($className)) {
        //         $objects[] = $object;
        //     }

        //     return $objects;
        // }
    }