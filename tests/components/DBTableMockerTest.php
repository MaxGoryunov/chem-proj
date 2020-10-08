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
         * 
         * @dataProvider provideTableNamesAndPrimaryKeys
         *
         * @param string $tableName - name of the described table
         * @param (string|null)[] $expected - expected result
         * @return void
         */
        public function testGetTableDescription(string $tableName, array $expected):void {
            $tableMocker = new DBTableMocker();
            
            $this->assertContains($expected, $tableMocker->getTableDescription($tableName));
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
    }