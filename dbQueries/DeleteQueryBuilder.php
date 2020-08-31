<?php

    /**
     * Class for building a Delete query
     */
    class DeleteQueryBuilder extends AbstractQueryBuilder {
        
        use WhereTrait;

        use LimitTrait;

        /**
         * {@inheritDoc}
         */
        public function build():IQuery {
            return new Query("
                DELETE FROM `{$this->tableName}`
                {$this->where}
                {$this->limit};
            ");
        }
    }