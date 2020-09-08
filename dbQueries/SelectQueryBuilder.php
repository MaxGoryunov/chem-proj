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

        /**
         * The LIMIT string
         *
         * @var string
         */
        private $limit = "";

        /**
         * The JOIN statements
         *
         * @var string
         */
        private $joins = "";

        /**
         * Returns a statement with the selected columns
         *
         * @return string
         */
        public function getWhat():string {
            return $this->what;
        }

        /**
         * Returns a GROUP BY statement
         *
         * @return string
         */
        public function getGroupBy():string {
            return $this->groupBy;
        }

        /**
         * Returns a HAVING statement
         *
         * @return string
         */
        public function getHaving():string {
            return $this->having;
        }

        /**
         * Returns an ORDER BY statement
         *
         * @return string
         */
        public function getOrderBy():string {
            return $this->orderBy;
        }

        /**
         * Returns a LIMIT ... statement
         *
         * @return string
         */
        public function getLimit():string {
            return $this->limit;
        }

        /**
         * Returns JOIN statements
         *
         * @return string
         */
        public function getJoins():string {
            return $this->joins;
        }

        /**
         * Constructs a statement with the selected columns
         *
         * @param string[] $columns - columns to be selected
         * 
         * @return self
         */
        public function what(array $columns = []):self {
            if (empty($columns)) {
                return $this;
            }

            $what = "";

            if (!empty($columns)) {
                foreach ($columns as $columnKey => $column) {
                    /**
                     * If the $columnKey is string then the algorithm constructs an ALIAS statement, otherwise just adds the $column to the search string $what
                     */
                    if (is_string($columnKey)) {
                        $what .= "`$column` AS `$columnKey`, ";
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
        public function groupBy(string $columnName = ""):self {
            if ($columnName === "") {
                return $this;
            }
            
            $this->groupBy = "GROUP BY `$columnName`";

            return $this;
        }

        /**
         * Constructs a HAVING statement
         *
         * @param string $condition
         * 
         * @return self
         */
        public function having(string $condition = ""):self {
            if ($condition === "") {
                return $this;
            }
            
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
         * Constructs a LIMIT statement
         *
         * @param int $limit - max number of rows in query
         * @param int $offset - offset for operation, rows before $offset will not be affected
         * 
         * @return self
         */
        public function limit(int $limit, int $offset = 0):self {
            $this->limit = "LIMIT $offset, $limit";

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
                SELECT {$this->getWhat()}
                FROM `{$this->getTableName()}`
                {$this->getJoins()}
                {$this->getWhere()}
                {$this->getGroupBy()}
                {$this->getHaving()}
                {$this->getOrderBy()}
                {$this->getLimit()};
            ");
        }

    }