<?php

    namespace DBQueries;

    /**
     * Class for building a DESCRIBE query
     */
    class DescribeQueryBuilder extends AbstractQueryBuilder {

        /**
         * {@inheritDoc}
         */
        public function getQueryString():string {
            return "DESCRIBE `{$this->getTableName()}`;";
        }
        
        /**
         * {@inheritDoc}
         */
        public function build():IQuery {
            return new Query($this);
        }
    }
