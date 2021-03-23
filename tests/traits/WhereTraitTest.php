<?php

    use DBQueries\IQuery;
    use DBQueries\IQueryBuilder;
    use PHPUnit\Framework\TestCase;
    use Traits\WhereTrait;
    use DBQueries\SelectQueryBuilder;

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

                public function getQueryString():string {
                    return "";
                }
        
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
         * @covers ::statement
         * @covers ::getWhere
         * 
         * @small
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
         * @covers ::statement
         * @covers ::getWhere
         * 
         * @small
         *
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
         * @covers ::statement
         * @covers ::getWhere
         * 
         * @small
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
         * @covers ::statement
         * @covers ::getWhere
         * 
         * @dataProvider provideStatements
         * 
         * @small
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
         * @covers ::statement
         * @covers ::getWhere
         * 
         * @dataProvider provideStatements
         * 
         * @small
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
         * @covers ::statement
         * @covers ::getWhere
         * 
         * @dataProvider provideStatements
         * 
         * @small
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
         * @covers ::where
         * @covers ::statement
         * @covers ::getWhere
         * 
         * @dataProvider provideQuoteVariations
         * 
         * @small
         *
         * @param string $statement - applied statement
         * @param string $expected  - expected result
         * @return void
         */
        public function testWhereBuildsCorrectStatementWithDifferentQuoteVariations(string $statement, string $expected):void {
            $this->builder->where($statement);

            $this->assertEquals("WHERE " . $expected, $this->builder->getWhere());
        }

        /**
         * @covers ::and
         * @covers ::statement
         * @covers ::getWhere
         * 
         * @dataProvider provideQuoteVariations
         * 
         * @small
         *
         * @param string $statement - applied statement
         * @param string $expected  - expected result
         * @return void
         */
        public function testAndBuildsCorrectStatementWithDifferentQuoteVariations(string $statement, string $expected):void {
            $this->builder->and($statement);

            $this->assertEquals("WHERE " . $expected, $this->builder->getWhere());
        }

        /**
         * @covers ::or
         * @covers ::statement
         * @covers ::getWhere
         * 
         * @dataProvider provideQuoteVariations
         * 
         * @small
         *
         * @param string $statement - applied statement
         * @param string $expected  - expected result
         * @return void
         */
        public function testOrBuildsCorrectStatementWithDifferentQuoteVariations(string $statement, string $expected):void {
            $this->builder->or($statement);

            $this->assertEquals("WHERE " . $expected, $this->builder->getWhere());
        }

        /**
         * @covers ::where
         * @covers ::and
         * @covers ::or
         * @covers ::statement
         * @covers ::getWhere
         * 
         * @small
         *
         * @return void
         */
        public function testBuildsCorrectStatementWithDifferentMethods():void {
            $this->builder->where("id = 1")
                            ->and("name = John")
                            ->or("email = johndoe@example.com")
                            ->or("password = admin");
            
            $this->assertEquals("WHERE `id` = '1' AND `name` = 'John' OR `email` = 'johndoe@example.com' OR `password` = 'admin'", $this->builder->getWhere());
        }

        /**
         * @return string[][][][]
         */
        public function provideStatements():array {
            return [
                [[
                    ["`name` = 'John'", "`name` = 'John'"],
                    ["`price` = '300'", "`price` = '300'"],
                    ["`desc` = 'This is a description'", "`desc` = 'This is a description'"]
                ]]
            ];
        }

        /**
         * @return string[][]
         */
        public function provideQuoteVariations():array {
            return [
                ["`name` = 'John'", "`name` = 'John'"],
                ["`name` = John", "`name` = 'John'"],
                ["name = 'John'", "`name` = 'John'"],
                ["name = John", "`name` = 'John'"]
            ];
        }
    }