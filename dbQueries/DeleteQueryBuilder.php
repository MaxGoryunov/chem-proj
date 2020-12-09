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
        public function getQueryString():string {
            return "
                DELETE FROM `{$this->getTableName()}`
                {$this->getWhere()}
                {$this->getLimit()};
            ";
        }

        /**
         * {@inheritDoc}
         */
        public function build():IQuery {
            return new Query($this);
        }
    }