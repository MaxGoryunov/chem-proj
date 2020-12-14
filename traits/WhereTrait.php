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
         * Contains the type of  link: none, Or or And
         *
         * @var string
         */
        private $linkType = "";

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
         * Returns the link type
         *
         * @return string
         */
        public function getLinkType():string {
            return $this->linkType;
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
            if ($condition !== "") {
                $this->currentCondition = $condition;
                $this->linkType         = "None";
            }

            return $this;
        }

        /**
         * Specifies the WHERE ... AND ... statement
         *
         * @param string $condition  - condition to be added
         * @return $this
         */
        public function and(string $condition = ""):IQueryBuilder {
            if ($condition !== "") {
                $this->currentCondition = $condition;
                $this->linkType         = "And";
            }

            return $this;
        }

        /**
         * Specifies the WHERE ... OR ... statement
         *
         * @param string $condition  - condition to be added
         * @return $this
         */
        public function or(string $condition = ""):IQueryBuilder {
            if ($condition !== "") {
                $this->currentCondition = $condition;
                $this->linkType         = "Or";
            }

            return $this;
        }

        /**
         * Completes the building of the statement with '=' sign 
         *
         * @param string $value
         * @return $this
         */
        public function equals(string $value = ""):IQueryBuilder {
            if ($value !== "") {
                $this->currentCondition .= " = '$value'";
                
                $this->push();
            }

            return $this;
        }

        /**
         * Returns a link for the initiation methods based on the link type
         *
         * @return string
         */
        private function getInitLink():string {
            return ([
                "None" => "",
                "Or" => "Or",
                "And" => "And"
            ])[$this->linkType];
        }

        /**
         * Returns a link for they query based on the link type
         *
         * @return string
         */
        private function getQueryLink():string {
            return strtoupper($this->getInitLink());
        }

        /**
         * Pushes the built statement to the where statement
         *
         * @return void
         */
        private function push():void {
            $this->{"initWhere" . $this->getInitLink()}();

            $this->where           .= " {$this->getQueryLink()} {$this->currentCondition}"; 
            $this->linkType         = "";
            $this->currentCondition = "";
        }
    }