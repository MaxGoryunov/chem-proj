<?php

    namespace DBQueries;
    
    /**
     * Class for holding a query string to DB
     */
    class Query implements IQuery {
        
        /**
         * Holds a string value
         *
         * @var string
         */
        private $queryString = "";

        /**
         * Accepts the query builder as a parameter to encapsulate the string acquisition
         *
         * @param IQueryBuilder $queryBuilder
         */
        public function __construct(IQueryBuilder $queryBuilder) {
            $this->queryString = $queryBuilder->getQueryString();
        }

        /**
         * {@inheritDoc}
         */
        public function getQueryString():string {
            return $this->queryString;
        }
    }