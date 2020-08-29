<?php

    /**
     * Trait supports LIMIT statements
     */
    trait LimitTrait {

        /**
         * Contains the LIMIT string
         *
         * @var string
         */
        private $limit = "";

        /**
         * Specifies the LIMIT statement
         *
         * @param int $limit - max number of rows in query
         * @param int $offset - offset for operation, rows before $offset will not be affected
         * 
         * @return IQueryBuilder
         */
        public function limit(int $limit, int $offset = 0):IQueryBuilder {
            $this->limit = "LIMIT $offset, $limit";

            return $this;
        }
    }