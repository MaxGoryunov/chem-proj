<?php

    namespace Components;

    use DBQueries\DescribeQueryBuilder;
    use DBQueries\Query;

    /**
     * Class which is used for mocking Db Tables which allows proper testing
     */
    class DBTableMocker {

        /**
         * Contains an array of stored table columns
         *
         * @var string[][]
         */
        private $columns = [];

        /**
         * Returns an array of table columns with their description
         *
         * @param string $tableName
         * @return string[][]
         */
        public function getTableDescription(string $tableName):array {
            $connection = new MySQLConnection(); 

            $result  = $connection->query(new DescribeQueryBuilder($tableName));
            $columns = $result->fetch_all(MYSQLI_ASSOC);
            
            foreach ($columns as $column) {
                $this->columns[$column["Field"]] = $column;
            }

            return $columns;
        }
    }