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
         * Contains the condition string which is being added to the overall WHERE statement
         *
         * @var string
         */
        private $currentCondition = "";

        /**
         * Returns WHERE statement
         *
         * @return string
         */
        public function getWhere():string {
            return $this->where;
        }

        
        /**
         * Returns the condition being constructed
         *
         * @return string
         */
        public function getCurrentCondition():string {
            return $this->currentCondition;
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

            $this->where .= " `$condition`";

            return $this;
        }

        /**
         * Specifies the WHERE ... AND ... statement
         *
         * @param string $condition  - condition to be added
         * @return $this
         */
        public function and(string $condition = ""):IQueryBuilder {
            if ($condition === "") {
                return $this;
            }

            $this->initWhereAnd();

            $this->where .= " AND `$condition`";

            return $this;
        }

        /**
         * Specifies the WHERE ... OR ... statement
         *
         * @param string $condition  - condition to be added
         * @return $this
         */
        public function or(string $condition = ""):IQueryBuilder {
            if ($condition === "") {
                return $this;
            }

            $this->initWhereOr();
            
            $this->where .= " OR `$condition`";

            return $this;
        }

        /**
         * Completes the building of the statement with '=' sign 
         *
         * @param string $value
         * @return $this
         */
        public function equals(string $value = ""):IQueryBuilder {
            if ($value === "") {
                return $this;
            }

            $this->currentCondition .= " = '$value'";
            $this->where            .= $this->currentCondition;
            $this->currentCondition  = "";

            return $this;
        }
    }