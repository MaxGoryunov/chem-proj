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
        private $where = "WHERE 1";

        /**
         * @todo Implement a stricter version of the algorithm so that it does not just simply accept the string $condition
         */
        /**
         * Specifies the WHERE ... AND ... statement
         *
         * @param string $condition  - condition to be added
         * 
         * @return SelectQueryBuilder|DeleteQueryBuilder|UpdateQueryBuilder
         */
        public function whereAnd(string $condition):IQueryBuilder {
            $this->where .= " AND " . $condition;

            return $this;
        }

        /**
         * Specifies the WHERE ... OR ... statement
         *
         * @param string $condition  - condition to be added
         * 
         * @return SelectQueryBuilder|DeleteQueryBuilder|UpdateQueryBuilder
         */
        public function whereOr(string $condition):IQueryBuilder {
            $this->where .= " OR " . $condition;

            return $this;
        }
    }