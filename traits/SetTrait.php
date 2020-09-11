<?php

    namespace Traits;

    use DBQueries\IQueryBuilder;

    /**
     * Trait supports SET `column_name` = VALUE statements
     */
    trait SetTrait {
        
        /**
         * Values to be set in the query
         *
         * @var string
         */
        private $values = "";

        /**
         * Returns VALUES statement
         *
         * @return string
         */
        public function getValues():string {
            return $this->values;
        }

        /**
         * Sets $values based on given array of data
         *
         * @param array $values
         * 
         * @return $this
         */
        public function set(array $values = []):IQueryBuilder {
            $set = "";

            foreach ($values as $columnName => $value) {
                /**
                 * If the $columnName is not a string and is just an array index then it cannot be used as a column name and the method has to be aborted
                 */
                if (is_string($columnName)) {
                    $set .= "`{$columnName}` = '$value', ";
                } else {
                    return $this;
                }
            }

            $set          = rtrim($set, ", ");
            $this->values = $set;

            return $this;

        }
    }