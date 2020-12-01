<?php

    namespace DBQueries;

    class DescribeQueryBuilder extends AbstractQueryBuilder {
        
        /**
         * {@inheritDoc}
         */
        public function build():IQuery {
            return new Query(
                "DESCRIBE `{$this->getTableName()}`;"
            );
        }
    }