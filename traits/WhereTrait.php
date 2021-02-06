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
            if (($constraint !== "") && ($value !== "")) {
                $relationsExists = $this->relations[$relation] ?? null;

                if (isset($relationsExists)) {
                    $this->where = "WHERE $constraint $relation $value";
                }
            }

            return $this;
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
            if (($constraint !== "") && ($value !== "")) {
                $relationsExists = $this->relations[$relation] ?? null;

                if (isset($relationsExists)) {
                    if ($this->where === "") {
                        $where = "WHERE ";
                    } else {
                        $where = " AND ";
                    }

                    $where .= "$constraint $relation $value";

                    $this->where .= $where;
                }
            }

            return $this;
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
            if (($constraint !== "") && ($value !== "")) {
                $relationsExists = $this->relations[$relation] ?? null;

                if (isset($relationsExists)) {
                    if ($this->where === "") {
                        $where = "WHERE ";
                    } else {
                        $where = " OR ";
                    }

                    $where .= "$constraint $relation $value";

                    $this->where .= $where;
                }
            }

            return $this;
        }
    }