<?php

    namespace Traits;

    /**
     * This trait allows to store and get the name of DB Table related to a class using the trait
     */
    trait TableNameTrait {
        
        /**
         * Contains the name of the Database Table
         *
         * @var string
         */
        protected $tableName = "";

        /**
         * Returns the name of the Database Table
         *
         * @return string
         */
        public function getTableName():string {
            return $this->tableName;
        }
    }
    