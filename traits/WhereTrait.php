<?php

    namespace Traits;

    use DBQueries\IQueryBuilder;

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
                $this->where = "WHERE 1";
            }
        }

        /**
         * Initiates string starter for first call of 'whereAnd' method
         *
         * @return void
         */
        private function initWhereOr():void {
            if ($this->where === "") {
                $this->where = "WHERE 0";
            }
        }

        /**
         * Initiates string starter for first call of 'where' method
         *
         * @return void
         */
        private function initWhere():void {
            if ($this->where === "") {
                $this->where = "WHERE";
            }
        }

        /**
         * Specifies the WHERE statement
         *
         * @param string $condition - condition to be added
         * @return $this
         */
        public function where(string $condition = ""):IQueryBuilder {
            if ($condition === "") {
                return $this;
            }

            $this->initWhere();

            $this->where .= " " . $condition;

            return $this;
        }

        /**
         * Specifies the WHERE ... AND ... statement
         *
         * @param string $condition  - condition to be added
         * @return $this
         */
        public function whereAnd(string $condition = ""):IQueryBuilder {
            if ($condition === "") {
                return $this;
            }

            $this->initWhereAnd();

            $this->where .= " AND " . $condition;

            return $this;
        }

        /**
         * Specifies the WHERE ... OR ... statement
         *
         * @param string $condition  - condition to be added
         * @return $this
         */
        public function whereOr(string $condition = ""):IQueryBuilder {
            if ($condition === "") {
                return $this;
            }

            $this->initWhereOr();
            
            $this->where .= " OR " . $condition;

            return $this;
        }
    }