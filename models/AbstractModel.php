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
        protected string $table = "";

        /**
         * @param string $table
         */
        public function __construct(string $table) {
            $this->table = $table;
        }

        /**
         * Returns table name to which the model relates
         *
         * @return string
         */
        public function getTableName():string {
            return $this->table;
        }
    }
