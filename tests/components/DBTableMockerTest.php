<?php

    namespace Tests\Components;

    use Components\DBTableMocker;
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
        }

        /**
         * @covers ::mockTable
         *
         * @return void
         */
        public function testMockTableCreatesCorrectTable():void {

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