<?php

    namespace Traits;

    use DBQueries\IQueryBuilder;

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
         * @return $this
         */
        public function limit(int $limit):IQueryBuilder {
            if ($limit < 0) {
                $limit = 0;
            }
            
            $this->limit = "LIMIT " . $limit;

            return $this;
        }
    }
