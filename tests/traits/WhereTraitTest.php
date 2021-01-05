<?php

    use DBQueries\IQuery;
    use DBQueries\IQueryBuilder;
    use PHPUnit\Framework\TestCase;
    use Traits\WhereTrait;

    /**
     * Testing WhereTrait trait
     * 
     * @coversDefaultClass Traits\WhereTrait
     */
    class WhereTraitTest extends TestCase {
        
        /**
         * Contains class which uses tested trait
         *
         * @var SelectQueryBuilder
         */
        protected $builder;

        /**
         * Creates mock for class which uses tested trait
         *
         * @return void
         */
        protected function setUp():void {
            $this->builder = new class() implements IQueryBuilder {
                use WhereTrait;
        
                public function build():IQuery {
                    return new class() implements IQuery {};
                }
            };
        }

        /**
         * Removes mock for class which uses tested trait
         *
         * @return void
         */
        protected function tearDown():void {
            $this->builder = null;
        }

        /**
         * @covers ::whereAnd
         * @covers ::initWhereAnd
         * @covers ::getWhere

         * @return void
         */
        public function testWhereAndBuildsCorrectWhereAndStatementOnEmptyInput():void {
            $this->assertInstanceOf(IQueryBuilder::class, $this->builder->whereAnd(""));

            $this->assertEquals("", $this->builder->getWhere());
        }

        /**
         * @covers ::whereOr
         * @covers ::initWhereOr
         * @covers ::getWhere

         * @return void
         */
        public function testWhereOrBuildsCorrectWhereOrStatementOnEmptyInput():void {
            $this->assertInstanceOf(IQueryBuilder::class, $this->builder->whereOr(""));

            $this->assertEquals("", $this->builder->getWhere());
        }

        /**
         * @covers ::whereOr
         * @covers ::initWhereOr
         * @covers ::whereAnd
         * @covers ::initWhereAnd
         * @covers ::getWhere
         * 
         * @dataProvider provideMixedWhereConditions
         *
         * @param string[][] $statements - statements to be built
         * @param string $expected - expected result
         * @return void
         */
        public function testsWhereBuildCorrectWhereStatement(array $statements, string $expected):void {
            foreach ($statements as $statement) {
                if ($statement["type"] == "and") {
                    $this->builder->whereAnd($statement["condition"]);
                } else {
                    $this->builder->whereOr($statement["condition"]);
                }
            }

            $this->assertEquals($expected, $this->builder->getWhere());
        }

        /**
         * @covers ::whereOr
         * @covers ::initWhereOr
         * @covers ::whereAnd
         * @covers ::initWhereAnd
         * @covers ::getWhere
         *
         * @return void
         */
        public function testBadUsageOfWhereMethods():void {
            $this->builder->whereAnd("");
            $this->builder->whereOr("");
            $this->builder->whereAnd("");

            $this->builder->whereAnd("`medicine_id` = 1");
            $this->builder->whereOr("");
            $this->builder->whereOr("`medicine_price` < 750");
            $this->builder->whereAnd("");

            $this->assertEquals("WHERE 1 AND `medicine_id` = 1 OR `medicine_price` < 750", $this->builder->getWhere());
        }

        /**
         * Provides different condition combinations for testing that both 'whereOr' and 'whereAnd' are built correctly
         *
         * @return (string[][]|string)[][]
         */
        public function provideMixedWhereConditions():array {
            return [
                "multipleAnds" => [
                    [
                        [
                            "type"      => "and",
                            "condition" => "`medicine_id` = 1"
                        ],
                        [
                            "type"      => "and",
                            "condition" => "`medicine_price` < 750"
                        ],
                        [
                            "type"      => "and",
                            "condition" => "`medicine_doze` > 30"
                        ]
                    ],
                    "WHERE 1 AND `medicine_id` = 1 AND `medicine_price` < 750 AND `medicine_doze` > 30"
                ],
                "multipleOrs"  => [
                    [
                        [
                            "type"      => "or",
                            "condition" => "`medicine_id` = 1"
                        ],
                        [
                            "type"      => "or",
                            "condition" => "`medicine_price` < 750"
                        ],
                        [
                            "type"      => "or",
                            "condition" => "`medicine_doze` > 30"
                        ]
                    ],
                    "WHERE 0 OR `medicine_id` = 1 OR `medicine_price` < 750 OR `medicine_doze` > 30"
                ],
                "mixed"        => [
                    [
                        [
                            "type"      => "or",
                            "condition" => "`medicine_id` = 1"
                        ],
                        [
                            "type"      => "and",
                            "condition" => "`medicine_price` < 750"
                        ],
                        [
                            "type"      => "or",
                            "condition" => "`medicine_doze` > 30"
                        ]
                    ],
                    "WHERE 0 OR `medicine_id` = 1 AND `medicine_price` < 750 OR `medicine_doze` > 30"
                ]
            ];
        }
    }