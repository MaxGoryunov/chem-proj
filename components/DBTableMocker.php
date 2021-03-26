<?php

    namespace Components;

use DBQueries\CreateTableQueryBuilder;
use DBQueries\DescribeQueryBuilder;
    use DBQueries\DropTableQueryBuilder;
use Models\AbstractModel;

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
                "MUL" => false,
                "UNI" => false,
                ""    => false
            ],
            "Extra" => [
                "auto_increment"                => true,
                "on update current_timestamp()" => false,
                ""                              => false
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

            $result  = $connection->query(new DescribeQueryBuilder(
                new class("$tableName") extends AbstractModel {}
            ));
            $columns = $result->fetch_all(MYSQLI_ASSOC);
            
            foreach ($columns as $column) {
                $split      = preg_split("/[()]/", $column["Type"], -1, PREG_SPLIT_NO_EMPTY);
                $split[1] ??= "";

                $this->columns[$column["Field"]] = (new TableColumn($column["Field"]))
                                                    ->setType($split[0], $split[1])
                                                    ->setNull(self::MAP["Null"][$column["Null"]])
                                                    ->setAutoIncrement(self::MAP["Extra"][$column["Extra"]])
                                                    ->setPrimaryKey(self::MAP["Key"][$column["Key"]]);
            }

            return $this->columns;
        }

        /**
         * Creates a new mock table
         *
         * @param string $tableName
         * @return void
         */
        public function mockTable(string $tableName):void {
            $connection = new MySQLConnection();
            $drop       = new DropTableQueryBuilder(
                new class("mock_$tableName") extends AbstractModel {}
            );
            
            $connection->query($drop);

            $create = (new CreateTableQueryBuilder(
                new class("mock_$tableName") extends AbstractModel {}
            ))
                        ->setColumns(
                            $this->getTableDescription($tableName)
                        );

            $connection->query($create);
        }

        /**
         * Clears created mock table
         *
         * @param string $tableName
         * @return void
         */
        public function clearMock(string $tableName):void {
            $connection = new MySQLConnection();
            $builder    = new DropTableQueryBuilder(
                new class("mock_$tableName") extends AbstractModel {}
            );

            $connection->query($builder);
        }
    }
