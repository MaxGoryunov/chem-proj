<?php

    namespace DBQueries;

    /**
     * Class for building a DROP TABLE query
     */
    class DropTableQueryBuilder extends AbstractQueryBuilder {

        /**
         * {@inheritDoc}
         */
        public function getQueryString():string {
            return "DROP TABLE IF EXISTS `{$this->getTableName()}`;";
        }

        /**
         * {@inheritDoc}
         */
        public function build():IQuery {
            return new Query($this);
        }
    }
