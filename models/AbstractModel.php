<?php

    namespace Models;
    
    /**
     * Base class for implementing other Models
     */
    abstract class AbstractModel {

        /**
         * Table name to which the model belongs
         *
         * @var string
         */
        private $tableName;

        /**
         * Returns table name
         *
         * @return string
         */
        public function getTableName():string {
            return $this->tableName;
        }
    }
