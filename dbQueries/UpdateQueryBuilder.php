<?php

    namespace DBQueries;

    use Traits\{SetTrait, WhereTrait, LimitTrait};

    /**
     * Class for building an Update query
     */
    class UpdateQueryBuilder extends AbstractQueryBuilder {

        use SetTrait;

        use WhereTrait;

        use LimitTrait;

        /**
         * {@inheritDoc}
         */
        public function getQueryString():string {
            return "
                UPDATE `{$this->getTableName()}`
                SET {$this->getValues()}
                {$this->getWhere()}
                {$this->getLimit()};
            ";
        }
    }
