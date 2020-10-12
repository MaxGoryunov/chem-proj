<?php

    namespace Tests\Components;

    use Components\DBTableMocker;
    use mysqli;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing DBTableMocker class
     * 
     * @coversDefaultClass DBTableMocker
     */
    class DBTableMockerTest extends TestCase {

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
            $tableMocker = new DBTableMocker();
            
            $this->assertContains($expected, $tableMocker->getTableDescription($tableName));
            $this->assertEquals("", $tableMocker->getCurrentColumn());
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
            $tableMocker = new DBTableMocker();

            $tableMocker->getTableDescription($table);

            $this->assertNull($tableMocker->column($column));
            $this->assertEquals($column, $tableMocker->getCurrentColumn());
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