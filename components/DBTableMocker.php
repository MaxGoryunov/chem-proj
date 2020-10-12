<?php

    namespace Components;

    use DBQueries\Query;

    /**
     * Class which is used for mocking Db Tables which allows proper testing
     */
    class DBTableMocker {

        /**
         * Name of the column which is being changed
         *
         * @var string
         */
        private $currentColumn = "";

        /**
         * Returns an array of table columns with their description
         *
         * @param string $tableName
         * @return string[][]
         */
        public function getTableDescription(string $tableName):array {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = new Query("DESCRIBE `$tableName`");

            $result  = $connection->query($query->getQueryString());
            $columns = $result->fetch_all(MYSQLI_ASSOC);

            return $columns;
        }

        /**
         * Sets the current column
         *
         * @param string $column
         * @return void
         */
        public function column(string $column):void {
            $this->currentColumn = $column;
        }

        /**
         * Returns the current column
         *
         * @return string
         */
        public function getCurrentColumn():string {
            return $this->currentColumn;
        }
    }