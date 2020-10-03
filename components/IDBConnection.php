<?php

    namespace Components;

    use DBQueries\Query;

    /**
     * Interface for various Database Connections such as MySQL, PostgreSQL etc.
     */
    interface IDBConnection {

        /**
         * Returns a Database Connection
         *
         * @return mixed
         */
        public function getConnection();

        /**
         * Performs a Database query
         *
         * @param Query $query
         * @return mixed
         */
        public function query(Query $query);

        /**
         * Returns all matched rows from Database Table
         *
         * @param Query $query
         * @param int $resultType
         * @return array
         */
        public function fetchAll(Query $query, int $resultType = 1):array;

        /**
         * Returns a single matched row from Database Table
         *
         * @param Query $query
         * @return array
         */
        public function fetchAssoc(Query $query):array;
    }