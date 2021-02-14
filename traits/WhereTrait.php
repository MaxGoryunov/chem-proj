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
         * @var string
         */
        private $where = "";

        /**
         * Base method which is extended by public methods
         *
         * @param string $constraint  - field which is being specified
         * @param string $relation    - relation between field and value
         * @param string $value       - field value
         * @param string $whereOption - alternative for $where when it is not empty
         * @param string $whereBase   - parameter which must be added to construct a new where statement
         * @return $this
         */
        private function statement(string $constraint, string $relation, string $value, string $whereOption, string $whereBase):IQueryBuilder {
            if (($constraint !== "") && ($value !== "")) {
                $relationsExists = $this->relations[$relation] ?? null;

                if (isset($relationsExists)) {
                    if ($this->where === "") {
                        $where = "WHERE ";
                    } else {
                        $where = $whereOption;
                    }

                    $where       .= "$constraint $relation $value";
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
         * @param string $constraint - field which is being specified
         * @param string $relation   - relation between field and value
         * @param string $value      - field value
         * @return $this
         */
        public function where(string $constraint, string $relation, string $value):IQueryBuilder {
            return $this->statement($constraint, $relation, $value, "WHERE ", "");
        }

        /**
         * Specifies the WHERE ... AND ... statement
         *
         * @param string $constraint - field which is being specified
         * @param string $relation   - relation between field and value
         * @param string $value      - field value
         * @return $this
         */
        public function and(string $constraint, string $relation, string $value):IQueryBuilder {
            return $this->statement($constraint, $relation, $value, " AND ", $this->where);
        }

        /**
         * Specifies the WHERE ... OR ... statement
         *
         * @param string $constraint - field which is being specified
         * @param string $relation   - relation between field and value
         * @param string $value      - field value
         * @return $this
         */
        public function or(string $constraint, string $relation, string $value):IQueryBuilder {
            return $this->statement($constraint, $relation, $value, " OR ", $this->where);
        }
    }