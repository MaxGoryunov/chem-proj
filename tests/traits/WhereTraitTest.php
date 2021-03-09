<?php

    use DBQueries\IQuery;
    use DBQueries\IQueryBuilder;
    use PHPUnit\Framework\TestCase;
    use Traits\WhereTrait;
    use DBQueries\SelectQueryBuilder;

    /**
     * Testing WhereTrait trait
     * 
     * @coversDefaultClass WhereTrait
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
         * @covers ::where
         * @covers ::initWhere
         * @covers ::getWhere
         * @covers ::getCurrentCondition
         *
         * @return void
         */
        public function testWhereBuildsCorrectWhereStatementOnEmptyInput():void {
            $this->assertInstanceOf(IQueryBuilder::class, $this->builder->where(" > 10"));
            $this->assertEquals("", $this->builder->getWhere());

            
            $this->assertInstanceOf(IQueryBuilder::class, $this->builder->where("name > "));
            $this->assertEquals("", $this->builder->getWhere());
        }

        /**
         * @covers ::and
         * @covers ::initWhereAnd
         * @covers ::getWhere
         * @covers ::getCurrentCondition
         * @return void
         */
        public function testWhereAndBuildsCorrectWhereAndStatementOnEmptyInput():void {
            $this->assertInstanceOf(IQueryBuilder::class, $this->builder->and(" > 10"));
            $this->assertEquals("", $this->builder->getWhere());

            $this->assertInstanceOf(IQueryBuilder::class, $this->builder->and("name > "));
            $this->assertEquals("", $this->builder->getWhere());
        }

        /**
         * @covers ::or
         * @covers ::initWhereOr
         * @covers ::getWhere
         * @covers ::getCurrentCondition
         * 
         * @return void
         */
        public function testWhereOrBuildsCorrectWhereOrStatementOnEmptyInput():void {
            $this->assertInstanceOf(IQueryBuilder::class, $this->builder->or(" > 10"));
            $this->assertEquals("", $this->builder->getWhere());

            $this->assertInstanceOf(IQueryBuilder::class, $this->builder->or("name > "));
            $this->assertEquals("", $this->builder->getWhere());
        }

        /**
         * @covers ::where
         * 
         * @dataProvider provideStatements
         *
         * @param string[][] $statements
         * @return void
         */
        public function testWhereBuildsCorrectStatement(array $statements):void {
            foreach ($statements as $statement) {
                $this->builder->where($statement[0]);

                $this->assertEquals("WHERE " . $statement[1], $this->builder->getWhere());
            }
        }

        /**
         * @covers ::and
         * 
         * @dataProvider provideStatements
         *
         * @param string[][] $statements
         * @return void
         */
        public function testAndBuildsCorrectStatement(array $statements):void {
            $expected = "WHERE";

            foreach ($statements as $statement) {
                $this->builder->and($statement[0]);

                $expected .= ($expected === "WHERE") ? " " : " AND ";
                $expected .= $statement[1];

                $this->assertEquals($expected, $this->builder->getWhere());
            }
        }

        /**
         * @covers ::or
         * 
         * @dataProvider provideStatements
         *
         * @param string[][] $statements
         * @return void
         */
        public function testOrBuildsCorrectStatement(array $statements):void {
            $expected = "WHERE";

            foreach ($statements as $statement) {
                $this->builder->or($statement[0]);

                $expected .= ($expected === "WHERE") ? " " : " OR ";
                $expected .= $statement[1];

                $this->assertEquals($expected, $this->builder->getWhere());
            }
        }

        /**
         * @return string[][][][]
         */
        public function provideStatements():array {
            return [
                [[
                    ["`name` = 'John'", "`name` = 'John'"],
                    ["`price` = 300", "`price` = 300"],
                    ["`desc` = 'This is a description'", "`desc` = 'This is a description'"]
                ]]
            ];
        }
    }