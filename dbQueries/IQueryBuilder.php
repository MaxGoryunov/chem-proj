<?php

    namespace DBQueries;
    
    /**
     * Interface for building queries to DB
     */
    interface IQueryBuilder {

        /**
         * Returns the created string
         *
         * @return string
         */
        public function getQueryString():string;

        /**
         * Returns an IQuery Object which can be used for retrieving a query string
         *
         * @return IQuery
         */
        public function build():IQuery;
    }