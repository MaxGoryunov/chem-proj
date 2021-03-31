<?php

    namespace Tests\DBQueries;

    use Components\TableColumn;
    use InvalidArgumentException;
    use PHPUnit\Framework\TestCase;

    /**
     * @coversDefaultClass Components\TableColumn
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
         * @small
         *
         * @param string $name
         * @return void
         */
        public function testConstructSetsColumnName(string $name):void {
            $column = new TableColumn($name);

            $this->assertEquals($name, $column->getName());
        }

        /**
         * @covers ::__construct
         * @covers ::getNull
         * @covers ::setNull
         * 
         * @small
         *
         * @return void
         */
        public function testSetNullSetsNullValue():void {
            $this->assertSame($this->column, $this->column->setNull(true));
            $this->assertEquals("", $this->column->getNull());

            $this->assertSame($this->column, $this->column->setNull(false));
            $this->assertEquals("NOT NULL", $this->column->getNull());
        }

        /**
         * @covers ::__construct
         * @covers ::getAutoIncrement
         * @covers ::setAutoIncrement
         * 
         * @small
         *
         * @return void
         */
        public function testSetAutoIncrementSetsAutoIncrementValue():void {
            $this->assertSame($this->column, $this->column->setAutoIncrement(true));
            $this->assertEquals("AUTO_INCREMENT", $this->column->getAutoIncrement());

            $this->assertSame($this->column, $this->column->setAutoIncrement(false));
            $this->assertEquals("", $this->column->getAutoIncrement());
        }

        /**
         * @covers ::__construct
         * @covers ::getPrimaryKey
         * @covers ::setPrimaryKey
         * 
         * @small
         *
         * @return void
         */
        public function testSetPrimaryKeySetsPrimaryKeyValue():void {
            $this->assertSame($this->column, $this->column->setPrimaryKey(true));
            $this->assertEquals("PRIMARY KEY", $this->column->getPrimaryKey());

            $this->assertSame($this->column, $this->column->setPrimaryKey(false));
            $this->assertEquals("", $this->column->getPrimaryKey());
        }

        /**
         * @covers ::__construct
         * @covers ::setType
         * @covers ::getType
         * 
         * @small
         *
         * @return void
         */
        public function testSetTypeSetsTypeWithSize():void {
            $this->assertSame($this->column, $this->column->setType("int", 10));

            $this->assertEquals("INT(10)", $this->column->getType());

            $this->assertSame($this->column, $this->column->setType("varchar", 30));

            $this->assertEquals("VARCHAR(30)", $this->column->getType());
        }

        /**
         * @covers ::__construct
         * @covers ::setType
         * @covers ::getType
         * 
         * @small
         *
         * @return void
         */
        public function testSetTypeSetsTypeWithoutSize():void {
            $this->assertSame($this->column, $this->column->setType("text"));
            $this->assertEquals("TEXT", $this->column->getType());

            $this->assertSame($this->column, $this->column->setType("timestamp"));
            $this->assertEquals("TIMESTAMP", $this->column->getType());
        }

        /**
         * @covers ::__construct
         * @covers ::setType
         * @covers ::getType
         * 
         * @small
         *
         * @return void
         */
        public function testSetTypeSetsStringSize():void {
            $this->assertSame($this->column, $this->column->setType("int", "10"));
            $this->assertEquals("INT(10)", $this->column->getType());

            $this->assertSame($this->column, $this->column->setType("varchar", "25"));
            $this->assertSame("VARCHAR(25)", $this->column->getType());
        }

        /**
         * @covers ::__construct
         * @covers ::setType
         * @covers ::getType
         * 
         * @small
         *
         * @return void
         */
        public function testSetTypeCorrectlySetsFloatTypeWithCommaSize():void {
            $this->assertSame($this->column, $this->column->setType("float", "3,2"));
            $this->assertEquals("FLOAT(3,2)", $this->column->getType());
        }

        /**
         * @covers ::__construct
         * @covers ::setType
         * @covers ::getType
         * 
         * @small
         *
         * @return void
         */
        public function testSetTypeThrowsExceptionIfTheTypeIsNotAValidSQLType():void {
            $this->expectException(InvalidArgumentException::class);

            $this->assertSame($this->column, $this->column->setType("aaaa"));

            $this->assertEquals("", $this->column->getType());
        }

        /**
         * @covers ::__construct
         * @covers ::getAutoIncrement
         * @covers ::getName
         * @covers ::getNull
         * @covers ::getPrimaryKey
         * @covers ::getType
         * @covers ::setAutoIncrement
         * @covers ::setNull
         * @covers ::setPrimaryKey
         * @covers ::setType
         * @covers ::getStatement
         * 
         * @dataProvider provideColumnData
         * 
         * @small
         *
         * @param string $name        - column name
         * @param bool $null          - can column be null or not
         * @param bool $autoIncrement - auto incremented column
         * @param bool $primaryKey    - is column a primary key
         * @param array $type         - column type
         * @param string $expected    - expected result
         * @return void
         */
        public function testGetStatementReturnsCorrectStatement(string $name, bool $null, bool $autoIncrement, bool $primaryKey, array $type, string $expected):void {
            $column = new TableColumn($name);

            $column->setNull($null)
                    ->setAutoIncrement($autoIncrement)
                    ->setPrimaryKey($primaryKey)
                    ->setType(...$type);

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