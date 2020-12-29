<?php

    namespace DBQueries;

    /**
     * Class for building a Create table query
     */
    class CreateTableQueryBuilder extends AbstractQueryBuilder {

        /**
         * Contains columns which are going to be used in the resulting table
         *
         * @var string[][]
         */
        private $columns = [];

        /**
         * Column which is being changed
         *
         * @var string
         */
        private $currentColumn = "";

        /**
         * Primary column
         * 
         * Only one column can be primary at a time
         *
         * @var string
         */
        private $primaryColumn = "";

        /**
         * Returns the current column
         *
         * @return string[]
         */
        public function getCurrentColumn():array {
            return $this->columns[$this->currentColumn];
        }

        /**
         * Returns current column name
         *
         * @return string
         */
        public function getCurrentColumnName():string {
            return $this->currentColumn;
        }

        /**
         * Sets the column which is being modified
         *
         * @param string $columnName
         * @return $this
         */
        public function column(string $columnName):self {
            $this->currentColumn                 = $columnName;
            
            if (!isset($this->columns[$this->currentColumn])) {
                $this->columns[$this->currentColumn] = [];
            }

            return $this;
        }

        /**
         * Sets the NULL status of the column
         *
         * @param bool $status
         * @return $this
         */
        public function canBeNull(bool $status):self {
            $this->columns[$this->currentColumn]["Null"] = ($status) ? "YES" : "NO";

            return $this;
        }

        /**
         * Sets the Extra property of the column and defined if the column is auto incremented or not
         *
         * @param bool $status
         * @return $this
         */
        public function autoIncrement(bool $status):self {
            $this->columns[$this->currentColumn]["Extra"] = ($status) ? "auto_increment" : "";

            return $this;
        }

        /**
         * sets the current column as primary
         *
         * @param bool $status
         * @return $this
         */
        public function isPrimaryKey(bool $status):self {
            /**
             * If the current column is primary then it can be set immediately
             */
            if ($this->currentColumn === $this->primaryColumn) {
                $this->columns[$this->primaryColumn]["Primary"] = ($status) ? "primary key" : "";
            } else {
                if ($status) {
                    $this->columns[$this->currentColumn]["Primary"] = "primary key";

                    /**
                     * If the primary column is already set then that column primary key must be removed
                     */
                    if (isset($this->primaryColumn)) {
                        $this->columns[$this->primaryColumn]["Primary"] = "";
                    }

                    $this->primaryColumn = $this->currentColumn;
                }
            }

            return $this;
        }

        /**
         * {@inheritDoc}
         */
        public function getQueryString():string {
            return "";
        }

        /**
         * {@inheritDoc}
         */
        public function build():IQuery {
            return new Query($this);
        }
    }