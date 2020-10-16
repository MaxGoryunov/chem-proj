<?php

    namespace Tests\Components;

use Components\DBConnectionProvider;
use Components\DBTableMocker;
use Components\IDBConnection;
use PHPUnit\Framework\TestCase;

    /**
     * Testing DBTableMocker class
     * 
     * @coversDefaultClass DBTableMocker
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
         * @dataProvider provideTableNamesAndPrimaryKeys
         *
         * @param string $tableName         - name of the described table
         * @param (string|null)[] $expected - expected result
         * @return void
         */
        public function testGetTableDescription(string $tableName, array $expected):void {            
            $this->assertContains($expected, $this->mocker->getTableDescription($tableName));
            $this->assertEquals("", $this->mocker->getCurrentColumn());
        }

        /**
         * @covers ::getTableDescription
         * @covers ::column
         * @covers ::getCurrentColumn
         *
         * @return void
         */
        public function testColumnDoesNotSetUpCurrentColumnOnInvalidColumnNameInput():void {
            $this->mocker->getTableDescription("addresses");

            $this->assertInstanceOf(DBTableMocker::class, $this->mocker->column("id"));
            $this->assertEquals("", $this->mocker->getCurrentColumn());
        }

        /**
         * @covers ::getTableDescription
         * @covers ::column
         * @covers ::getCurrentColumn
         * 
         * @dataProvider provideColumns
         *
         * @param string $table  - table which the column belongs t0
         * @param string $column - name of the column
         * @return void
         */
        public function testColumnMethodSetsUpWorkingColumn(string $table, string $column):void {
            $this->mocker->getTableDescription($table);

            $this->assertInstanceOf(DBTableMocker::class, $this->mocker->column($column));
            $this->assertEquals($column, $this->mocker->getCurrentColumn());
        }

        /**
         * @return ((string|null)[]|string)[][]
         */
        public function provideTableNamesAndPrimaryKeys():array {
            return [
                "addresses" => [
                    "addresses",
                    array(
                        "Field"   => "address_id",
                        "Type"    => "int(10)",
                        "Null"    => "NO",
                        "Key"     => "PRI",
                        "Default" => null,
                        "Extra"   => "auto_increment"
                    )
                ],
                "medicines" => [
                    "medicines",
                    array(
                        "Field"   => "medicine_id",
                        "Type"    => "int(10)",
                        "Null"    => "NO",
                        "Key"     => "PRI",
                        "Default" => null,
                        "Extra"   => "auto_increment"
                    )
                ],
                "companies" => [
                    "companies",
                    array(
                        "Field"   => "company_id",
                        "Type"    => "int(10)",
                        "Null"    => "NO",
                        "Key"     => "PRI",
                        "Default" => null,
                        "Extra"   => "auto_increment"
                    )
                ]
            ];
        }

        /**
         * @return string[][]
         */
        public function provideColumns():array {
            return [
                "address_id" => ["addresses", "address_id"],
                "address_name" => ["addresses", "address_name"],
                "medicine_id" => ["medicines", "medicine_id"]
            ];
        }
    }