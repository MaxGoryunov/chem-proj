<?php

    /**
     * Class for building a Select query
     */
    class SelectQueryBuilder extends AbstractQueryBuilder {

        /**
         * Columns to be selected from DB Table
         *
         * @var string
         */
        private $what = "*";

        use WhereTrait;

        /**
         * The GROUP BY statement
         *
         * @var string
         */
        private $groupBy = "";

        /**
         * The HAVING statement
         *
         * @var string
         */
        private $having = "";

        /**
         * The ORDER By statement
         *
         * @var string
         */
        private $orderBy = "";

        use OffsetLimitTrait;

        /**
         * The JOIN statements
         *
         * @var string
         */
        private $joins = "";

        /**
         * Constructs a statement with the selected columns
         *
         * @param string[] $columns - columns to be selected
         * 
         * @return self
         */
        public function what(array $columns = []):self {
            $what = "";

            if (!empty($columns)) {
                foreach ($columns as $columnKey => $column) {
                    /**
                     * If the $columnKey is string then the algorithm constructs an ALIAS statement, otherwise just adds the $column to the search string $what
                     */
                    if (is_string($columnKey)) {
                        $what .= "$column AS `$columnKey`, ";
                    } else {
                        $what .= "`$column`, ";
                    }
                }
            }

            $what       = rtrim($what, ", ");
            $this->what = $what;

            return $this;
        }

        /**
         * Constructs a GROUP BY statement
         *
         * @param string $columnName
         * 
         * @return self
         */
        public function groupBy(string $columnName):self {
            $this->groupBy = "GROUP BY `$columnName`";

            return $this;
        }

        /**
         * @todo Implement a stricter version of the algorithm so that it does not just simply accept the string $condition
         */
        /**
         * Constructs a HAVING statement
         *
         * @param string $condition
         * 
         * @return self
         */
        public function having(string $condition):self {
            $this->having = "HAVING " . $condition;

            return $this;
        }

        /**
         * Constructs an ORDER BY statement
         *
         * @param string[] $columns
         * 
         * @return self
         */
        public function orderBy(array $columns = []):self {
            $orderBy = "ORDER BY ";

            foreach ($columns as $columnKey => $column) {
                /**
                 * If the sorting order is specified and is valid then it is applied, otherwise just adds the $column to the order string $orderBy
                 */
                if (in_array($columnKey, ["ASC", "DESC"])) {
                    $orderBy .= "$column $columnKey, ";
                } else {
                    $orderBy .= "$column, ";
                }
            }

            $orderBy       = rtrim($orderBy, ", ");
            $this->orderBy = $orderBy;

            return $this;
        }

        /**
         * Constructs a JOIN statement
         *
         * @param string $table - table to join
         * @param string $connectField - field of the $table to join
         * @param string $foreignConnectField - field of $tableName to join
         * @param string $joinType - type of JOIN statement
         * 
         * @return self
         */
        public function join(string $table, string $connectField, string $foreignConnectField, string $joinType = "LEFT"):self {
            $joinStmt = "";

            if (in_array($joinType, ["INNER", "LEFT", "RIGHT", "FULL OUTER"])) {
                $joinStmt .= "$joinType JOIN `$table` ON `$connectField` = `$foreignConnectField`";
            } else {
                $joinStmt .= "LEFT JOIN `$table` ON `$connectField` = `$foreignConnectField`";
            }

            $this->joins .= "
            $joinStmt";

            return $this;
        }

        /**
         * {@inheritDoc}
         */
        public function build():IQuery {
            return new Query("
                SELECT {$this->what}
                FROM `{$this->tableName}`
                {$this->joins}
                {$this->where}
                {$this->groupBy}
                {$this->having}
                {$this->orderBy}
                {$this->limit};
            ");
        }

    }