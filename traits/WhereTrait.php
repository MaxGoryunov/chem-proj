<?php

    /**
     * Trait supports WHERE statements
     */
    trait WhereTrait {

        /**
         * Contains the WHERE string
         *
         * @var string
         */
        private $where = "";

        /**
         * @todo Implement a stricter version of the algorithm so that it does not just simply accept the string $condition
         */
        /**
         * Specifies the WHERE statement
         *
         * @param string $condition
         * 
         * @return SelectQueryBuilder
         */
        public function where(string $condition):IQueryBuilder {
            $this->where = "WHERE 1 AND " . $condition;

            return $this;
        }
    }