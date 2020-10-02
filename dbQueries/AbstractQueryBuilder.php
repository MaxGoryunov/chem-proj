<?php

    namespace DBQueries;

    use Traits\TableNameTrait;

    /**
     * Abstract class for different specific queries: Select, Update, Insert and Delete
     */
    abstract class AbstractQueryBuilder implements IQueryBuilder {
        
        use TableNameTrait;

        /**
         * @param string $tableName
         * 
         * @return void
         */
        public function __construct(string $tableName) {
            $this->tableName = $tableName;
        }

        /**
         * Builds a Query object
         *
         * @return IQuery
         */
        public abstract function build():IQuery;
    }