<?php

    namespace DBQueries;
<<<<<<< HEAD

    use Traits\{SetTrait, WhereTrait, LimitTrait};

=======
    
    use Traits\{SetTrait, WhereTrait, LimitTrait};
>>>>>>> feature/namespaces
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
                UPDATE `{$this->getTableName()}`
                SET {$this->getValues()}
                {$this->getWhere()}
                {$this->getLimit()};
            ");
        }
    }