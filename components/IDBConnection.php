<?php

    namespace Components;

use DBQueries\IQueryBuilder;
use DBQueries\Query;

    /**
     * Interface for various Database Connections such as MySQL, PostgreSQL etc.
     */
    interface IDBConnection {

        /**
         * Performs a Database query
         *
         * @param IQueryBuilder $builder
         * @return mixed
         */
        public function query(IQueryBuilder $builder);

        /**
         * Returns all matched rows from Database Table
         *
         * @param IQueryBuilder $builder
         * @param int $resultType
         * @return array
         */
        public function fetchAll(IQueryBuilder $builder, int $resultType = 1):array;

        /**
         * Returns a single matched row from Database Table
         *
         * @param IQueryBuilder $builder
         * @return array|string
         */
        public function fetchAssoc(IQueryBuilder $builder, string $alias = "");
    }