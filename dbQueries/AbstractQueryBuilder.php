<?php

    namespace DBQueries;

    use Models\AbstractModel;

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
         * @param AbstractModel $model
         * @return void
         */
        public function __construct(AbstractModel $model) {
            $this->tableName = $model->getTableName();
        }

        /**
         * Returns DB Table to which the query is made
         *
         * @return string
         */
        public function getTableName():string {
            return $this->tableName;
        }

        /**
         * {@inheritDoc}
         */
        public function build():IQuery {
            return new Query($this);
        }
    }
