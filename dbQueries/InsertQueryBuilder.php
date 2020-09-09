<?php

    /**
     * Class for building and Insert query
     */
    class InsertQueryBuilder extends AbstractQueryBuilder {
        
        use SetTrait;

        /**
         * {@inheritDoc}
         */
        public function build():IQuery {
            return new Query("
                INSERT INTO `{$this->getTableName()}`
                SET {$this->getValues()};
            ");
        }
    }