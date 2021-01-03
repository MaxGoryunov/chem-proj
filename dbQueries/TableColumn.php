<?php

    namespace DBQueries;

    class TableColumn {

        /**
         * Defines if column can be null or not
         *
         * @var string
         */
        private $null = "";

        /**
         * Defines if the column is auto incremented or not
         *
         * @var string
         */
        private $autoIncrement = "";

        /**
         * Defines if the column is primary key or not
         *
         * @var string
         */
        private $primaryKey = "";

        /**
         * Returns null value
         *
         * @return string
         */
        public function getNull():string {
            return $this->null;
        }

        /**
         * Returns auto increment value
         *
         * @return string
         */
        public function getAutoIncrement():string {
            return $this->autoIncrement;
        }

        /**
         * Returns primary key value
         *
         * @return string
         */
        public function getPrimaryKey():string {
            return $this->primaryKey;
        }

        /**
         * Sets null value
         *
         * @param bool $null
         * @return void
         */
        public function setNull(bool $null):void {
            $this->null = strtoupper(($null) ? "" : "not null");
        }

        /**
         * Sets auto increment value
         *
         * @param bool $autoIncrement
         * @return void
         */
        public function setAutoIncrement(bool $autoIncrement):void {
            $this->autoIncrement = strtoupper(($autoIncrement) ? "auto_increment" : "");
        }

        /**
         * Sets primary key value
         *
         * @param bool $primaryKey
         * @return void
         */
        public function setPrimaryKey(bool $primaryKey):void {
            $this->primaryKey = strtoupper(($primaryKey) ? "primary key" : "");
        }
    }