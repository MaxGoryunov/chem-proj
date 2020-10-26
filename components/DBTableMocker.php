<?php

    namespace Components;

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
         * Column which is being changed
         *
         * @var string[]
         */
        private $currentColumn = [];

        /**
         * Returns an array of table columns with their description
         *
         * @param string $tableName
         * @return string[][]
         */
        public function getTableDescription(string $tableName):array {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = new Query("DESCRIBE `$tableName`");

            $result        = $connection->query($query->getQueryString());
            $columns       = $result->fetch_all(MYSQLI_ASSOC);
            
            foreach ($columns as $column) {
                $this->columns[$column["Field"]] = $column;
            }

            return $columns;
        }

        /**
         * Sets the column which is being modified
         *
         * @param string $columnName
         * @return $this
         */
        public function column(string $columnName):self {
            if (array_key_exists($columnName, $this->columns)) {
                $this->currentColumn = $this->columns[$columnName];
            }

            return $this;
        }

        /**
         * Returns the current column
         *
         * @return string[]
         */
        public function getCurrentColumn():array {
            return $this->currentColumn;
        }

        /**
         * Sets the NULL status of the column
         *
         * @param bool $status
         * @return $this
         */
        public function canBeNull(bool $status):self {
            $this->currentColumn["Null"] = ($status) ? "YES" : "NO";

            return $this;
        }

        
    }