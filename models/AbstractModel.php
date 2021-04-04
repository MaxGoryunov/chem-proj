<?php

    namespace Models;
    
    /**
     * Base class for implementing other Models
     */
    abstract class AbstractModel {

        /**
         * Table name to which the model relates
         *
         * @var string
         */
        protected $tableName = "";

        /**
         * @param string $tableName
         */
        public function __construct(string $tableName) {
            $this->tableName = $tableName;
        }

        /**
         * Returns table name to which the model relates
         *
         * @return string
         */
        public function getTableName():string {
            return $this->tableName;
        }
    }
