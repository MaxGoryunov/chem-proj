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
         * Returns WHERE statement
         *
         * @return string
         */
        public function getWhere():string {
            return $this->where;
        }

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
         * @return $this
         */
        public function whereOr(string $condition):IQueryBuilder {
            $this->where .= " OR " . $condition;

            return $this;
        }
    }