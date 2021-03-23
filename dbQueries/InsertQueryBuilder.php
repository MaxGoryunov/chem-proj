<?php

    namespace DBQueries;

    use Traits\SetTrait;

    /**
     * Class for building and Insert query
     */
    class InsertQueryBuilder extends AbstractQueryBuilder {
        
        use SetTrait;

        /**
         * {@inheritDoc}
         */
        public function getQueryString():string {
            return "
                INSERT INTO `{$this->getTableName()}`
                SET {$this->getValues()};
            ";
        }
    }