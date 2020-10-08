<?php

    namespace Components;

    use DBQueries\Query;

    /**
     * Class which is used for mocking Db Tables which allows proper testing
     */
    class DBTableMocker {
        public function getTableDescription(string $tableName):array {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = new Query("DESCRIBE `$tableName`");

            $result  = $connection->query($query->getQueryString());
            $columns = $result->fetch_all(MYSQLI_ASSOC);

            return $columns;
        }
    }