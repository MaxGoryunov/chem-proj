<?php

    /**
     * Abstract class for different specific queries: Select, Update, Insert and Delete
     */
    abstract class AbstractQueryBuilder implements IQueryBuilder {
        
        /**
         * DB Table involved in the query
         *
         * @var string
         */
        protected $tableName = "";

        /**
         * @param string $tableName
         * 
         * @return void
         */
        public function __construct(string $tableName) {
            $this->tableName = $tableName;
        }
    }