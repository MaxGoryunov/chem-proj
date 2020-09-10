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
        public function build():IQuery {
            return new Query("
                UPDATE `{$this->tableName}`
                SET {$this->values}
                {$this->where}
                {$this->limit};
            ");
        }
    }