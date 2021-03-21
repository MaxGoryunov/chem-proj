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
            "smallint"  => true,
            "tinyint"   => true,
            "float"     => true,
            "varchar"   => true,
            "text"      => false,
            "timestamp" => false
        ];

        /**
         * Name of the column
         *
         * @var string
         */
        private $name;

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
         * @param string $name
         */
        public function __construct(string $name) {
            $this->name = $name;
        }

        /**
         * Returns column name
         *
         * @return string
         */
        public function getName():string {
            return $this->name;
        }

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
         * @return $this
         */
        public function setNull(bool $null):self {
            $this->null = strtoupper(($null) ? "" : "not null");

            return $this;
        }

        /**
         * Sets auto increment value
         *
         * @param bool $autoIncrement
         * @return $this
         */
        public function setAutoIncrement(bool $autoIncrement):self {
            $this->autoIncrement = strtoupper(($autoIncrement) ? "auto_increment" : "");

            return $this;
        }

        /**
         * Sets primary key value
         *
         * @param bool $primaryKey
         * @return $this
         */
        public function setPrimaryKey(bool $primaryKey):self {
            $this->primaryKey = strtoupper(($primaryKey) ? "primary key" : "");

            return $this;
        }

        /**
         * Sets the column type
         * 
         * @throws InvalidArgumentException if the $type is not valid
         *
         * @param string          $type - column type
         * @param int|string|null $size - column size for sized columns(have to accept string because of float format)
         * @return $this
         */
        public function setType(string $type, int|string|null $size):self {
            $sizeRequired = self::ALLOWED_TYPES[$type] ?? null;

            if (isset($sizeRequired)) {
                if ($sizeRequired) {
                    /**
                     * @todo Add coverage for this condition
                     */
                    if (is_string($size)) {
                        $parts  = explode(",", $size);
                        $actual = (int)$parts[0];

                        if (isset($parts[1])) {
                            $actual .= "," . (int)$parts[1];
                        }
                    } else {
                        $actual = $size;
                    }
                    $this->type = strtoupper($type . "($size)");
                } else {
                    $this->type = strtoupper($type);
                }
            } else {
                throw new InvalidArgumentException("Type must be a valid SQL type: $type is not among allowed types: " . implode(", ", array_keys(self::ALLOWED_TYPES)));
            }

            return $this;
        }

        /**
         * Returns a constructed statement with all information about the column
         *
         * @return string
         */
        public function getStatement():string {
            $statement = "`{$this->getName()}` {$this->getType()} {$this->getNull()} {$this->getAutoIncrement()} {$this->getPrimaryKey()}";

            return rtrim($statement, " ");
        }
    }