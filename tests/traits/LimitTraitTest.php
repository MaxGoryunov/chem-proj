<?php

    use DBQueries\IQuery;
    use DBQueries\IQueryBuilder;
    use PHPUnit\Framework\TestCase;
    use Traits\LimitTrait;

    /**
     * Testing LimitTrait trait
     * 
     * @coversDefaultClass Traits\LimitTrait
     */
    class LimitTraitTest extends TestCase {

        /**
         * Contains object for testing trait
         *
         * @var UpdateQueryBuilder
         */
        protected $builder;

        /**
         * Creates object for testing trait
         *
         * @return void
         */
        protected function setUp():void {
            $this->builder = new class() implements IQueryBuilder {
                use LimitTrait;

                public function getQueryString():string {
                    return "";
                }

                public function build():IQuery {
                    return new class() implements IQuery {};
                }
            };
        }

        /**
         * Removes object for testing trait
         *
         * @return void
         */
        protected function tearDown():void {
            $this->builder = null;
        }

        /**
         * @covers ::limit
         * @covers ::getLimit
         * 
         * @dataProvider provideLimits
         * 
         * @small
         *
         * @param int    $limit    - limit passed to 'limit' method
         * @param string $expected - expected result
         * @return void
         */
        public function testLimitConstructsCorrectStatement(int $limit, string $expected):void {
            $this->assertInstanceOf(IQueryBuilder::class, $this->builder->limit($limit));

            $this->assertEquals($expected, $this->builder->getLimit());
        }

        /**
         * Provides limits for testing 'limit' method
         *
         * @return (int|string)[][]
         */
        public function provideLimits():array {
            return [
                "negative" => [-4, "LIMIT 0"],
                "zero"     => [0, "LIMIT 0"],
                "positive" => [5, "LIMIT 5"]
            ];
        }
    }