<?php

    /**
     * Trait supports LIMIT N, M statements
     */
    trait OffsetLimitTrait {

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
         * @return SelectQueryBuilder
         */
        public function limit(int $limit, int $offset = 0):IQueryBuilder {
            $this->limit = "LIMIT $offset, $limit";

            return $this;
        }
    }