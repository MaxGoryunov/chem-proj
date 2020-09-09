<?php

    /**
     * Class for building and Insert query
     */
    class InsertQueryBuilder extends AbstractQueryBuilder {
        
        use SetTrait;

        /**
         * {@inheritDoc}
         */
        public function build():Query {
            return new Query("
                INSERT INTO `{$this->tableName}`
                SET {$this->values};
            ");
        }
    }