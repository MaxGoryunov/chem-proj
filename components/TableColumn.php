<?php

    namespace Components;

    use InvalidArgumentException;

    /**
     * Class contains data for creating a new table column
     */
    class TableColumn {

        /**
         * Allowed column types
         * 
         * Boolean values define if the column needs the size as a parameter or not
         * 
         * @var bool[]
         */
        private const ALLOWED_TYPES = [
            "int"       => true,
            "varchar"   => true,
            "text"      => false,
            "timestamp" => false
        ];

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
         * Defines column type
         *
         * @var string
         */
        private $type = "";

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
         * Returns type value
         *
         * @return string
         */
        public function getType():string {
            return $this->type;
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

        /**
         * Sets the column type
         * 
         * @throws InvalidArgumentException if the $type is not valid
         *
         * @param string $type - column type
         * @param int $size    - column size for integer and varchar columns
         * @return void
         */
        public function setType(string $type, int $size = null):void {
            $sizeRequired = self::ALLOWED_TYPES[$type] ?? null;

            if (isset($sizeRequired)) {
                if ($sizeRequired) {
                    $this->type = strtoupper($type . "($size)");
                } else {
                    $this->type = strtoupper($type);
                }
            } else {
                throw new InvalidArgumentException("Type must be a valid SQL type");
            }
        }
    }