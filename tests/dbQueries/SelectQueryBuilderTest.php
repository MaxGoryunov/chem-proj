<?php

    namespace Tests\DBQueries;

    use Models\AbstractModel;
    use DBQueries\SelectQueryBuilder;
use Models\IModel;
use PHPUnit\Framework\TestCase;

    /**
     * Testing SelectQueryBuilder
     * 
     * @coversDefaultClass DBQueries\SelectQueryBuilder
     */
    class SelectQueryBuilderTest extends TestCase {
        
        /**
         * Contains tested class object
         *
         * @var SelectQueryBuilder
         */
        protected $selectBuilder;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $model = $this->getMockBuilder(IModel::class)
                            ->disableOriginalConstructor()
                            ->getMock();
            $model->method("getTableName")->willReturn("medicines");

            $this->selectBuilder = new SelectQueryBuilder($model);
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->selectBuilder = null;
        }

        /**
         * @covers ::__construct
         * @covers ::getWhat
         * 
         * @uses DBQueries\AbstractQueryBuilder
         * 
         * @dataProvider provideWhatColumns
         *
         * @param array  $columns  - columns to be selected
         * @param string $expected - expected string
         * @return void
         */
        public function testConstructorBuildsCorrectWhatStatement(array $columns, string $expected):void {
            $model = $this->getMockBuilder(IModel::class)
                            ->disableOriginalConstructor()
                            ->getMock();
            $model->method("getTableName")->willReturn("medicines");

            $builder = new SelectQueryBuilder($model, $columns);

            $this->assertEquals($expected, $builder->getWhat());
        }

        /**
         * @covers ::__construct
         * @covers ::groupBy
         * @covers ::getGroupBy
         * 
         * @uses DBQueries\AbstractQueryBuilder
         * 
         * @dataProvider provideGroupByColumnNames
         *
         * @param string $columnName - column name to be grouped by
         * @param string $expected - expected result
         * @return void
         */
        public function testGroupByBuildsCorrectGroupByStatement(string $columnName, string $expected):void {
            $this->assertInstanceOf(SelectQueryBuilder::class, $this->selectBuilder->groupBy($columnName));

            $this->assertEquals($expected, $this->selectBuilder->getGroupBy());
        }

        /**
         * @covers ::__construct
         * @covers ::having
         * @covers ::getHaving
         * 
         * @uses DBQueries\AbstractQueryBuilder
         * 
         * @dataProvider provideHavingConditions
         *
         * @param string $condition - conditions to be included
         * @param string $expected - expected result
         * @return void
         */
        public function testHavingBuildsCorrectHavingStatement(string $condition, string $expected):void {
            $this->assertInstanceOf(SelectQueryBuilder::class, $this->selectBuilder->having($condition));

            $this->assertEquals($expected, $this->selectBuilder->getHaving());
        }

        /**
         * @covers ::__construct
         * @covers ::orderBy
         * @covers ::getOrderBy
         * 
         * @uses DBQueries\AbstractQueryBuilder
         * 
         * @dataProvider provideOrderByColumns
         *
         * @param array|string[] $columns - columns to be ordered by
         * @param string $expected - expected result
         * @return void
         */
        public function testOrderByBuildsCorrectOrderByStatement(array $columns, string $expected):void {
            $this->assertInstanceOf(SelectQueryBuilder::class, $this->selectBuilder->orderBy($columns));

            $this->assertEquals($expected, $this->selectBuilder->getOrderBy());
        }

        /**
         * @covers ::__construct
         * @covers ::limit
         * @covers ::getLimit
         * 
         * @uses DBQueries\AbstractQueryBuilder
         *
         * @return void
         */
        public function testLimitBuildsCorrectLimitStatementWithZeroOffset():void {
            $this->assertInstanceOf(SelectQueryBuilder::class, $this->selectBuilder->limit(5));

            $this->assertEquals("LIMIT 0, 5", $this->selectBuilder->getLimit());
        }

        /**
         * @covers ::__construct
         * @covers ::limit
         * @covers ::getLimit
         * 
         * @uses DBQueries\AbstractQueryBuilder
         *
         * @return void
         */
        public function testLimitBuildsCorrectLimitStatementWithPositiveOffset():void {
            $this->assertInstanceOf(SelectQueryBuilder::class, $this->selectBuilder->limit(5, 3));

            $this->assertEquals("LIMIT 3, 5", $this->selectBuilder->getLimit());
        }

        /**
         * @covers ::__construct
         * @covers ::join
         * @covers ::getJoins
         * 
         * @uses DBQueries\AbstractQueryBuilder
         * 
         * @dataProvider provideJoins
         *
         * @param string[][] $joins - joins passed to 'join' method
         * @param string $expected - expected result
         * @return void
         */
        public function testJoinBuildsCorrectJoinStatement(array $joins, string $expected):void {
            foreach ($joins as $join) {
                if (isset($join["joinType"])) {
                    $this->assertInstanceOf(SelectQueryBuilder::class, $this->selectBuilder->join($join["table"], $join["connectField"], $join["foreignConnectField"], $join["joinType"]));
                } else {
                    $this->assertInstanceOf(SelectQueryBuilder::class, $this->selectBuilder->join($join["table"], $join["connectField"], $join["foreignConnectField"]));
                }
            }

            $this->assertEquals($expected, preg_replace("/\s+/", " ", preg_replace("/\n/", " ", $this->selectBuilder->getJoins())));
        }

        /**
         * @covers ::__construct
         * @covers ::getWhat
         * @covers ::join
         * @covers ::getJoins
         * @covers ::groupBy
         * @covers ::getGroupBy
         * @covers ::orderBy
         * @covers ::getOrderBy
         * @covers ::limit
         * @covers ::getLimit
         * @covers ::getHaving
         * @covers ::getQueryString
         * @covers ::build
         * 
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\Query
         * @uses Traits\WhereTrait
         *
         * @return void
         */
        public function testBuildBuildsCorrectQueryObject():void {
            $model = $this->getMockBuilder(IModel::class)
                            ->disableOriginalConstructor()
                            ->getMock();
            $model->method("getTableName")->willReturn("medicines");

            $query = (new SelectQueryBuilder(
                $model, 
                ["medicine_id", "name" =>"medicine_name"])
            )->join("chemicals", "chemical_id", "medicine_chemical_id")
            ->join("companies", "company_id", "medicine_company_id")
            ->join("countries", "country_id", "medicine_country_id")
            ->where("`medicine_price` > 500")
            ->or("`medicine_doze` > 30")
            ->groupBy("medicine_price")
            ->orderBy([
                [
                    "name" => "medicine_name"
                ],
                [
                    "name"      => "medicine_price",
                    "orderType" => "DESC"
                ]
            ])
            ->limit(30)
            ->build();

            $this->assertEquals(preg_replace("/\n/", "", " SELECT `medicine_id`, `medicine_name` AS `name` FROM `medicines` LEFT JOIN `chemicals` ON `chemical_id` = `medicine_chemical_id` LEFT JOIN `companies` ON `company_id` = `medicine_company_id` LEFT JOIN `countries` ON `country_id` = `medicine_country_id` WHERE `medicine_price` > '500' OR `medicine_doze` > '30' GROUP BY `medicine_price` ORDER BY `medicine_name`, `medicine_price` DESC LIMIT 0, 30; "), preg_replace("/\s+/", " ", preg_replace("/\n/", " ", $query->getQueryString())));
        }

        /**
         * Provides different inputs for 'what' and expected results
         *
         * @return (string[]|string)[][]
         */
        public function provideWhatColumns():array {
            return [
                "empty"       => [
                    ["*"],
                    "*"
                ],
                "numericKeys" => [
                    [
                        "medicine_id",
                        "medicine_name",
                        "medicine_price",
                        "medicine_doze"
                    ],
                    "`medicine_id`, `medicine_name`, `medicine_price`, `medicine_doze`"
                ],
                "stringKeys"  => [
                    [
                        "id"    => "medicine_id",
                        "name"  => "medicine_name",
                        "price" => "medicine_price",
                        "doze"  => "medicine_doze"
                    ],
                    "`medicine_id` AS `id`, `medicine_name` AS `name`, `medicine_price` AS `price`, `medicine_doze` AS `doze`"
                ],
                "mixedKeys"   => [
                    [
                        "id"   => "medicine_id",
                        "name" => "medicine_name",
                        "medicine_price",
                        "medicine_doze"
                    ],
                    "`medicine_id` AS `id`, `medicine_name` AS `name`, `medicine_price`, `medicine_doze`"
                ],
                "functions"   => [
                    [
                        "COUNT(*)",
                        "AVG(*)",
                        "MIN(*)",
                        "MAX(*)"
                    ],
                    "COUNT(*), AVG(*), MIN(*), MAX(*)"
                ],
                "functionsKeys"   => [
                    [
                        "count"   => "COUNT(*)",
                        "avg"     => "AVG(*)",
                        "min"     => "MIN(*)",
                        "max"     => "MAX(*)"
                    ],
                    "COUNT(*) AS `count`, AVG(*) AS `avg`, MIN(*) AS `min`, MAX(*) AS `max`"
                ]
            ];
        }

        /**
         * Provides inputs and expected results for 'groupBy' method
         *
         * @return string[][]
         */
        public function provideGroupByColumnNames():array {
            return [
                "empty"           => ["", ""],
                "specific column" => ["medicine_price", "GROUP BY `medicine_price`"]
            ];
        }

        /**
         * Provides conditions and expected results fir 'having' method
         *
         * @return string[][]
         */
        public function provideHavingConditions():array {
            return [
                "empty"    => ["", ""],
                "specific" => ["`medicine_price` < 900", "HAVING `medicine_price` < 900"]
            ];
        }

        /**
         * Provides columns for 'orderBy' method
         *
         * @return (array|string[][]|string)[][]
         */
        public function provideOrderByColumns():array {
            return [
                "empty"                => [
                    [],
                    ""
                ],
                "directionNotSupplied" => [
                    [
                        ["name" => "medicine_name"],
                        ["name" => "medicine_price"]
                    ],
                    "ORDER BY `medicine_name`, `medicine_price`"
                ],
                "directionAsc"         => [
                    [
                        [
                            "name"      => "medicine_name",
                            "orderType" => "ASC"
                        ],
                        [
                            "name"      => "medicine_price",
                            "orderType" => "ASC"
                        ]
                    ],
                    "ORDER BY `medicine_name` ASC, `medicine_price` ASC"
                ],
                "directionDesc"        => [
                    [
                        [
                            "name"      => "medicine_name",
                            "orderType" => "DESC"
                        ],
                        [
                            "name"      => "medicine_price",
                            "orderType" => "DESC"
                        ]
                    ],
                    "ORDER BY `medicine_name` DESC, `medicine_price` DESC"
                ],
                "directionMixed"       => [
                    [
                        [
                            "name"      => "medicine_name",
                            "orderType" => "ASC"
                        ],
                        [
                            "name"      => "medicine_price",
                            "orderType" => "DESC"
                        ]
                    ],
                    "ORDER BY `medicine_name` ASC, `medicine_price` DESC"
                ]
            ];
        }

        /**
         * Provides joins for 'join' method
         *
         * @return (string[][]|string)[][]
         */
        public function provideJoins():array {
            return [
                "badJoinType"    => [
                    [
                        [
                            "table"               => "chemicals",
                            "connectField"        => "chemical_id",
                            "foreignConnectField" => "medicine_chemical_id",
                            "joinType"            => "FOO"
                        ],
                        [
                            "table"               => "companies",
                            "connectField"        => "company_id",
                            "foreignConnectField" => "medicine_company_id",
                            "joinType"            => "BAR"
                        ],
                        [
                            "table"               => "countries",
                            "connectField"        => "country_id",
                            "foreignConnectField" => "medicine_country_id",
                            "joinType"            => "BAZ"
                        ],
                    ],
                    " LEFT JOIN `chemicals` ON `chemical_id` = `medicine_chemical_id` LEFT JOIN `companies` ON `company_id` = `medicine_company_id` LEFT JOIN `countries` ON `country_id` = `medicine_country_id`"
                ],
                "properJoinType" => [
                    [
                        [
                            "table"               => "chemicals",
                            "connectField"        => "chemical_id",
                            "foreignConnectField" => "medicine_chemical_id",
                            "joinType"            => "INNER"
                        ],
                        [
                            "table"               => "companies",
                            "connectField"        => "company_id",
                            "foreignConnectField" => "medicine_company_id",
                            "joinType"            => "LEFT"
                        ],
                        [
                            "table"               => "countries",
                            "connectField"        => "country_id",
                            "foreignConnectField" => "medicine_country_id",
                            "joinType"            => "RIGHT"
                        ],
                        [
                            "table"               => "purposes",
                            "connectField"        => "purpose_id",
                            "foreignConnectField" => "medicine_purpose_id",
                            "joinType"            => "FULL OUTER"
                        ]
                    ],
                    " INNER JOIN `chemicals` ON `chemical_id` = `medicine_chemical_id` LEFT JOIN `companies` ON `company_id` = `medicine_company_id` RIGHT JOIN `countries` ON `country_id` = `medicine_country_id` FULL OUTER JOIN `purposes` ON `purpose_id` = `medicine_purpose_id`"
                ]
            ];
        }
    }