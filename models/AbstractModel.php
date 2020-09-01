<?php

    /**
     * Base class for implementing other Models
     */
    abstract class AbstractModel implements IModel {
        
        /**
         * Contains name of related Database Table
         *
         * @var string
         */
        protected $tableName = "";

        /**
         * Returns a name of related Database Table
         *
         * @return string
         */
        protected function getTableName():string {
            return $this->tableName;
        }
    }