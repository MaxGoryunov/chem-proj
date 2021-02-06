<?php

    namespace Components;

    use DBQueries\IQueryBuilder;
    use Entities\IEntity;

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

        /**
         * Returns a new object of the given class
         *
         * @param IQueryBuilder $builder - builder for retrieving a query string
         * @param string $className      - name of the class of the resulting object
         * @return IEntity
         */
        public function fetchObject(IQueryBuilder $builder, string $className):object;
    }