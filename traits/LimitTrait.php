<?php

    /**
     * Trait supports LIMIT N statements
     */
    trait LimitTrait {

        /**
         * Contains the LIMIT string
         *
         * @var string
         */
        private $limit = "";

        /**
         * Returns LIMIT statement
         *
         * @return string
         */
        public function getLimit():string {
            return $this->limit;
        }

        /**
         * Specifies the LIMIT statement
         *
         * @param int $limit - max number of rows in query
         * 
         * @return DeleteQueryBuilder|UpdateQueryBuilder
         */
        public function limit(int $limit):IQueryBuilder {
            $this->limit = "LIMIT " . $limit;

            return $this;
        }
    }