<?php

    namespace DBQueries;

    use Traits\LimitTrait;
    use Traits\WhereTrait;

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