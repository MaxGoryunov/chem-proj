<?php

    namespace Components;

    use InvalidArgumentException;

    /**
     * CLass for providing Database Connections
     * 
     * There are three main reasons for doing that:
     * 1. A lot of code is based on the work of Database Connection
     * 2. Now the code is dependent on the IDBConnection interface and not on the specific class
     * 3. I planned this project as PostgreSQL based, but since I have no experience with PostgreSQL I had to work with MySQL instead. This code structure simplifies the migration from one DBMS to another
     */
    class DBConnectionProvider {
        private static $connections = [
            IDBConnection::class => MySQLConnection::class
        ];

        /**
         * Function shortcuts the accessing of Database Connection with the help of the specified class
         *
         * @param string $connectionType - type of connection, supposed to be the Connection Interface
         * 
         * @return mixed
         */
        public static function getConnection(string $connectionType) {
            /**
             * If the connection type is present in the predefined connections then it can be accessed
             */
            if (array_key_exists($connectionType, self::$connections)) {
                return new self::$connections[$connectionType];
            }

            throw new InvalidArgumentException("Supplied argument of unknown type");
        }

    }