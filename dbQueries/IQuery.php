<?php

    namespace DBQueries;
    
    /**
     * Interface for queries to DB
     */
    interface IQuery {
        
        /**
         * Returns a query string created by QueryBuilder class
         *
         * @return string
         */
        public function getQueryString():string;
    }