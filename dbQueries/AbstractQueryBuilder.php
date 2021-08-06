<?php

    namespace DBQueries;

use Models\AbstractModel;
use Models\IModel;
use Traits\TableNameTrait;

    /**
     * Abstract class for different specific queries: Select, Update, Insert and Delete
     */
    abstract class AbstractQueryBuilder implements IQueryBuilder {
        
        use TableNameTrait;

        /**
         * @param IModel $model
         */
        public function __construct(IModel $model) {
            $this->tableName = $model->getTableName();
        }

        /**
         * Builds a Query object
         *
         * @return IQuery
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
