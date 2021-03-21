<?php

    namespace Components;

    use DBQueries\DescribeQueryBuilder;
    use DBQueries\Query;

    /**
     * Class which is used for mocking Db Tables which allows proper testing
     */
    class DBTableMocker {

        /**
         * Map resulting row values to values accepted by TableColumn
         * 
         * @var array<string, bool>[]
         */
        private const MAP = [
            "Null" => [
                "NO"  => false,
                "YES" => true
            ],
            "Key" => [
                "PRI" => true,
                ""    => false
            ],
            "Extra" => [
                "auto_increment" => true,
                ""               => false
            ]
        ];

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
         * @return TableColumn[]
         */
        public function getTableDescription(string $tableName):array {
            $connection = new MySQLConnection(); 

            $result  = $connection->query(new DescribeQueryBuilder($tableName));
            $columns = $result->fetch_all(MYSQLI_ASSOC);
            
            foreach ($columns as $column) {
                $this->columns[$column["Field"]] = (new TableColumn($column["Field"]))
                                                    ->setNull(self::MAP["Null"][$column["Null"]])
                                                    ->setAutoIncrement(self::MAP["Extra"][$column["Extra"]])
                                                    ->setPrimaryKey(self::MAP["Key"][$column["Key"]]);
            }

            return $this->columns;
        }
    }