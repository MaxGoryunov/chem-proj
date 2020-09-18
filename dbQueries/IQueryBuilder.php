<?php

    namespace DBQueries;
    
    /**
     * Interface for building queries to DB
     */
    interface IQueryBuilder {

        /**
         * Returns a IQuery Object which can be used for retrieving a query string
         *
         * @return IQuery
         */
        public function build():IQuery;
    }