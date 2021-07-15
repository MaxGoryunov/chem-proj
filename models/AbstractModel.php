<?php

    namespace Models;

use Components\DBServiceProvider;
use Components\IDBConnection;

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
         * Returns the Database connection
         *
         * @return IDBConnection
         */
        protected function connectToDB():IDBConnection {
            return (new DBServiceProvider())->getConnection();
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
