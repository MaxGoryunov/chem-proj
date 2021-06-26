<?php

    namespace DBQueries;

    use Traits\TableNameTrait;
    use Models\DomainModel;

    /**
     * Abstract class for different specific queries: Select, Update, Insert and Delete
     */
    abstract class AbstractQueryBuilder implements IQueryBuilder {
        
        use TableNameTrait;

        /**
         * @param AbstractModel $model
         * @return void
         */
        public function __construct(DomainModel $model) {
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
