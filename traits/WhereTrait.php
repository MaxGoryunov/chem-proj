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
        private $where = "WHERE";

        /**
         * Returns WHERE statement
         *
         * @return string
         */
        public function getWhere():string {
            return $this->where;
        }

        /**
         * Initiates string starter for first call of 'whereAnd' method
         *
         * @return void
         */
        private function initWhereAnd():void {
            if ($this->where === "") {
                $this->where .= " 1";
            }
        }

        private function initWhereOr():void {
            if ($this->where === "") {
                $this->where .= " 0";
            }
        }

        /**
         * Specifies the WHERE ... AND ... statement
         *
         * @param string $condition  - condition to be added
         * 
         * @return SelectQueryBuilder|DeleteQueryBuilder|UpdateQueryBuilder
         */
        public function whereAnd(string $condition = ""):IQueryBuilder {
            $this->initWhereAnd();

            if ($condition === "") {
                return $this;
            }

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
        public function whereOr(string $condition = ""):IQueryBuilder {
            $this->initWhereOr();

            if ($condition === "") {
                return $this;
            }
            
            $this->where .= " OR " . $condition;

            return $this;
        }
    }