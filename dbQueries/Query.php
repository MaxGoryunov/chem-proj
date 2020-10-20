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
         * Accepts the string through a constructor so that it cannot be changed later
         *
         * @param string $queryString
         */
        public function __construct(string $queryString) {
            $this->queryString = $queryString;
        }

        /**
         * {@inheritDoc}
         */
        public function getQueryString():string {
            return $this->queryString;
        }
    }