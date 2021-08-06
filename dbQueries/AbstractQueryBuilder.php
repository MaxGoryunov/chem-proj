<?php

    namespace DBQueries;

use Models\AbstractModel;
use Models\IModel;
use Traits\TableNameTrait;

    /**
     * Abstract class for different specific queries: Select, Update, Insert and Delete
     */
    abstract class AbstractQueryBuilder implements IQueryBuilder {
        
        /**
         * Ctor.
         * 
         * @param string $table
         */
        public function __construct(
            /**
             * Table name.
             * 
             * @var string
             */
            private string $table
        ) {
        }

        /**
         * Table name.
         *
         * @return string
         */
        public function getTableName():string {
            return $this->table;
        }

        /**
         * {@inheritDoc}
         */
        public function build():IQuery {
            return new Query($this);
        }
    }
