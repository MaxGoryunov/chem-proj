<?php

    namespace Tests\DBQueries;

    use Components\TableColumn;
    use InvalidArgumentException;
    use PHPUnit\Framework\TestCase;

    /**
     * @coversDefaultClass TableColumn
     */
    class TableColumnTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var TableColumn
         */
        protected $column;

        /**
         * Create tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->column = new TableColumn("name");
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->column = null;
        }

        /**
         * @covers ::__construct
         * @covers ::getName
         * 
         * @dataProvider provideNames
         *
         * @param string $name
         * @return void
         */
        public function testConstructSetsColumnName(string $name):void {
            $column = new TableColumn($name);

            $this->assertEquals($name, $column->getName());
        }

        /**
         * @covers ::getNull
         * @covers ::setNull
         *
         * @return void
         */
        public function testSetNullSetsNullValue():void {
            $this->column->setNull(true);
            $this->assertEquals("", $this->column->getNull());

            $this->column->setNull(false);
            $this->assertEquals("NOT NULL", $this->column->getNull());
        }

        /**
         * @covers ::getAutoIncrement
         * @covers ::setAutoIncrement
         *
         * @return void
         */
        public function testSetAutoIncrementSetsAutoIncrementValue():void {
            $this->column->setAutoIncrement(true);
            $this->assertEquals("AUTO_INCREMENT", $this->column->getAutoIncrement());

            $this->column->setAutoIncrement(false);
            $this->assertEquals("", $this->column->getAutoIncrement());
        }

        /**
         * @covers ::getPrimaryKey
         * @covers ::setPrimaryKey
         *
         * @return void
         */
        public function testSetPrimaryKeySetsPrimaryKeyValue():void {
            $this->column->setPrimaryKey(true);
            $this->assertEquals("PRIMARY KEY", $this->column->getPrimaryKey());

            $this->column->setPrimaryKey(false);
            $this->assertEquals("", $this->column->getPrimaryKey());
        }

        /**
         * @covers ::setType
         * @covers ::getType
         *
         * @return void
         */
        public function testSetTypeSetsTypeWithSize():void {
            $this->column->setType("int", 10);

            $this->assertEquals("INT(10)", $this->column->getType());

            $this->column->setType("varchar", 30);

            $this->assertEquals("VARCHAR(30)", $this->column->getType());
        }

        /**
         * @covers ::setType
         * @covers ::getType
         *
         * @return void
         */
        public function testSetTypeSetsTypeWithoutSize():void {
            $this->column->setType("text");

            $this->assertEquals("TEXT", $this->column->getType());

            $this->column->setType("timestamp");

            $this->assertEquals("TIMESTAMP", $this->column->getType());
        }

        /**
         * @covers ::setType
         * @covers ::getType
         *
         * @return void
         */
        public function testSetTypeThrowsExceptionIfTheTypeIsNotAValidSQLType():void {
            $this->expectException(InvalidArgumentException::class);

            $this->column->setType("aaaa");

            $this->assertEquals("", $this->column->getType());
        }

        /**
         * @covers ::getStatement
         *
         * @param string $name        - column name
         * @param bool $null          - can column be null or not
         * @param bool $autoIncrement - auto incremented column
         * @param bool $primaryKey    - is column a primary key
         * @param array $type         - column type
         * @param string $expected    - expected result
         * 
         * @dataProvider provideColumnData
         * 
         * @return void
         */
        public function testGetStatementReturnsCorrectStatement(string $name, bool $null, bool $autoIncrement, bool $primaryKey, array $type, string $expected):void {
            $column = new TableColumn($name);

            $column->setNull($null);
            $column->setAutoIncrement($autoIncrement);
            $column->setPrimaryKey($primaryKey);
            $column->setType(...$type);

            $this->assertEquals($expected, $column->getStatement());
        }

        /**
         * @return string[][]
         */
        public function provideNames():array {
            return [
                ["id"],
                ["name"],
                ["description"]
            ];
        }

        /**
         * Format: name, null, auto increment, primary key, type(size), expected result
         * 
         * @return ((string|int)[]|bool|string)[][]
         */
        public function provideColumnData():array {
            return [
                ["id", false, true, true, ["int", 10], "`id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY"],
                ["name", true, false, false, ["varchar", 30], "`name` VARCHAR(30)"],
                ["description", true, false, false, ["text"], "`description` TEXT"]
            ];
        }
    }