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
         * Initiates string starter for first call of 'where' method
         *
         * @return void
         */
        private function initWhere():void {
            if ($this->where === "") {
                $ending = [
                            "None" => "",
                            "Or" => " 0 ",
                            "And" => " 1 "
                        ][$this->linkType];
                
                $this->where = "WHERE" . $ending;
            } else {
                $this->where .= " ";
            }
        }

        /**
         * Sets the condition and the link type
         *
         * @param string $condition - condition to be added
         * @param string $linkType  - type of the condition link
         * @return $this
         */
        private function addCondition(string $condition = "", string $linkType):IQueryBuilder {
            if ($condition !== "") {
                $this->currentCondition = $condition;
                $this->linkType         = $linkType;
            }

            return $this;
        }

        /**
         * Returns a link for they query based on the link type
         *
         * @return string
         */
        private function getQueryLink():string {
            return [
                "None" => "",
                "Or" => "OR",
                "And" => "AND"
            ][$this->linkType];
        }

        /**
         * Pushes the built statement to the where statement
         *
         * @return void
         */
        private function push():void {
            $this->initWhere();

            $this->where           .= "{$this->getQueryLink()} {$this->currentCondition}"; 
            $this->linkType         = "";
            $this->currentCondition = "";
        }

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
         * Specifies the WHERE statement
         *
         * @param string $condition - condition to be added
         * @return $this
         */
        public function where(string $condition = ""):IQueryBuilder {
            return $this->addCondition($condition, "None");
        }

        /**
         * Specifies the WHERE ... AND ... statement
         *
         * @param string $condition  - condition to be added
         * @return $this
         */
        public function and(string $condition = ""):IQueryBuilder {
            return $this->addCondition($condition, "And");
        }

        /**
         * Specifies the WHERE ... OR ... statement
         *
         * @param string $condition  - condition to be added
         * @return $this
         */
        public function or(string $condition = ""):IQueryBuilder {
            return $this->addCondition($condition, "Or");
        }

        /**
         * Completes the building of the statement with '=' sign 
         *
         * @param string $value
         * @return $this
         */
        public function equals(string $value = ""):IQueryBuilder {
            if ($value !== "") {
                $this->currentCondition = "`{$this->getCurrentCondition()}` = '$value'";
                
                $this->push();
            }

            return $this;
        }

        /**
         * Completes the building of the statement with '<' sign
         *
         * @param string $value
         * @return $this
         */
        public function lessThan(string $value):IQueryBuilder {
            if ($value !== "") {
                $this->currentCondition = "`{$this->getCurrentCondition()}` < '$value'";

                $this->push();
            }

            return $this;
        }
    }