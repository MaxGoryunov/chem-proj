<?php

    namespace Tests\Components;

    use Components\DBTableMocker;
    use Components\TableColumn;
    use mysqli;
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
         * @param string $tableName - name of the described table
         * @return void
         */
        public function testGetTableDescription(string $tableName):void {
            $mysqli = new mysqli("localhost", "root", "", "chemistry");
            $cols   = $mysqli->query("DESCRIBE `$tableName`;")->fetch_all(MYSQLI_ASSOC);

            $dbToClassMap = [
                "NO"             => false,
                "YES"            => true,
                "PRI"            => true,
                "MUL"            => false,
                "UNI"            => false,
                "auto_increment" => true,
                ""               => false
            ];
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

            foreach ($cols as $col) {
                $split      = preg_split("/[()]/", $col["Type"], -1, PREG_SPLIT_NO_EMPTY);
                $split[1] ??= "";
                $columns[$col["Field"]] = (new TableColumn($col["Field"]))
                                ->setType($split[0], $split[1])
                                ->setNull($dbToClassMap[$col["Null"]])
                                ->setPrimaryKey($dbToClassMap[$col["Key"]])
                                ->setAutoIncrement($dbToClassMap[$col["Extra"]]);
            }

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
         * @return string[][]
         */
        public function provideTableNamesAndPrimaryKeys():array {
            return [
                "addresses" => ["addresses"],
                "medicines" => ["medicines"],
                "companies" => ["companies"]
            ];
        }
    }