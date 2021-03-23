<?php

    namespace Tests\Components;

    use Components\DBTableMocker;
    use mysqli;
use mysqli_sql_exception;
use PHPUnit\Framework\TestCase;

    /**
     * Testing DBTableMocker class
     * 
     * @coversDefaultClass Components\DBTableMocker
     */
    class DBTableMockerTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var DBTableMocker
         */
        protected $mocker;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->mocker = new DBTableMocker();
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->mocker = null;
        }

        /**
         * @covers ::getTableDescription
         * @covers ::getCurrentColumn
         * 
         * @dataProvider provideTableNames
         * 
         * @small
         *
         * @param string $tableName - name of the described table
         * @return void
         */
        public function testGetTableDescriptionReturnsCorrectTableDescription(string $tableName):void {
            $mysqli         = new mysqli("localhost", "root", "", "chemistry");
            $cols           = $mysqli->query("DESCRIBE `$tableName`;")->fetch_all(MYSQLI_ASSOC);
            $dbToStringsMap = [
                "Null" => [
                    "NO"  => "NOT NULL",
                    "YES" => ""
                ],
                "Key" => [
                    "PRI" => "PRIMARY KEY",
                    "MUL" => "",
                    "UNI" => "",
                    ""    => ""
                ],
                "Extra" => [
                    "auto_increment" => "AUTO_INCREMENT",
                    ""               => ""
                ]
            ];

            $columns = $this->mocker->getTableDescription($tableName);

            foreach ($cols as $col) {
                $key   = $col["Field"];
                $split = preg_split("/[()]/", $col["Type"], -1, PREG_SPLIT_NO_EMPTY);
                $type  = $split[0];

                if (isset($split[1])) {
                    $type .= "({$split[1]})";
                }

                $this->assertEquals($key, $columns[$key]->getName());
                $this->assertEquals(strtoupper($type), $columns[$key]->getType());
                $this->assertEquals($dbToStringsMap["Null"][$col["Null"]], $columns[$key]->getNull());
                $this->assertEquals($dbToStringsMap["Key"][$col["Key"]], $columns[$key]->getPrimaryKey());
                $this->assertEquals($dbToStringsMap["Extra"][$col["Extra"]], $columns[$key]->getAutoIncrement());

            }
        }

        /**
         * @covers ::getTableDescription
         * @covers ::mockTable
         * 
         * @dataProvider provideTableNames
         * 
         * @small
         *
         * @param string $table
         * @return void
         */
        public function testMockTableCreatesCorrectMockTable(string $table):void {
            $this->assertNull($this->mocker->mockTable($table));

            $original  = $this->mocker->getTableDescription($table);
            $resulting = $this->mocker->getTableDescription("mock_$table");

            foreach ($original as $column) {
                $name = $column->getName();
                $col  = $resulting[$name];

                $this->assertEquals($name, $col->getName());
                $this->assertEquals($column->getType(), $col->getType());
                $this->assertEquals($column->getAutoIncrement(), $col->getAutoIncrement());
                $this->assertEquals($column->getPrimaryKey(), $col->getPrimaryKey());
            }
        }

        /**
         * @covers ::mockTable
         * @covers ::clearMock
         * 
         * @dataProvider provideTableNames
         * 
         * @small
         *
         * @param string $name
         * @return void
         */
        public function testClearMockDropsMockTable(string $name):void {
            $this->mocker->mockTable($name);

            $mysqli = new mysqli("localhost", "root", "", "chemistry");

            $this->assertNotNull($mysqli->query("DESCRIBE `mock_$name`;"));
            $this->assertNull($this->mocker->clearMock($name));

            $this->expectException(mysqli_sql_exception::class);

            $mysqli->query("DESCRIBE `mock_$name`;");
        }

        /**
         * @return string[][]
         */
        public function provideTableNames():array {
            return [
                "addresses" => ["addresses"],
                "medicines" => ["medicines"],
                "companies" => ["companies"]
            ];
        }
    }