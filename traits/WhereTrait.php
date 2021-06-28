<?php

    namespace Traits;

    use DBQueries\IQueryBuilder;

    /**
     * Trait supports WHERE statements
     */
    trait WhereTrait {

        /**
         * Relation lookup
         *
         * @var bool[]
         */
        private $relations = [
            "="  => true,
            "<"  => true,
            ">"  => true,
            "<=" => true,
            ">=" => true
        ];

        /**
         * Contains the WHERE string
         * 
         * @todo Rename $where to $expression
         *
         * @var string
         */
        private $where = "";

        /**
         * Base method which is extended by public methods
         *
         * @param string $statement   - statement to be included in WHERE query
         * @param string $whereOption - alternative for $where when it is not empty
         * @param string $whereBase   - parameter which must be added to construct a new where statement
         * @return $this
         */
        private function statement(string $statement, string $whereOption, string $whereBase):IQueryBuilder {
            $replacedStatement               = preg_replace("/['`]/", "", $statement);
            [$constraint, $relation, $value] = preg_split("/[\s]/", $replacedStatement, 3, PREG_SPLIT_NO_EMPTY) + ["", "", ""];

            if (($constraint !== "") && ($value !== "")) {
                $relationsExists = $this->relations[$relation] ?? null;

                if (isset($relationsExists)) {
                    if ($this->where === "") {
                        $where = "WHERE ";
                    } else {
                        $where = $whereOption;
                    }

                    $where       .= "`$constraint` $relation '$value'";
                    $this->where = $whereBase . $where;
                }
            }

            return $this;
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
         * Specifies the WHERE statement
         *
         * @param string $statement - statement to be included
         * @return $this
         */
        public function where(string $statement):IQueryBuilder {
            return $this->statement($statement, "WHERE ", "");
        }

        /**
         * Specifies the WHERE ... AND ... statement
         *
         * @param string $statement - statement to be included
         * @return $this
         */
        public function and(string $statement):IQueryBuilder {
            return $this->statement($statement, " AND ", $this->where);
        }

        /**
         * Specifies the WHERE ... OR ... statement
         *
         * @param string $statement - statement to be included
         * @return $this
         */
        public function or(string $statement):IQueryBuilder {
            return $this->statement($statement, " OR ", $this->where);
        }
    }
