<?php

    use PHPUnit\Framework\TestCase;

    /**
     * Testing LimitTrait trait
     * 
     * @coversDefaultClass LimitTrait
     */
    class LimitTraitTest extends TestCase {

        /**
         * Contains object for testing trait
         *
         * @var UpdateQueryBuilder
         */
        protected $builder;

        protected function setUp():void {
            $this->builder = new class() implements IQueryBuilder {
                use LimitTrait;

                public function build():IQuery {
                    return new class() implements IQuery {};
                }
            };
        }

        /**
         * @covers ::limit
         * @covers ::getLimit
         * 
         * @dataProvider provideLimits
         *
         * @param int $limit - limit passed to 'limit' method
         * @param string $expected - expected result
         * @return void
         */
        public function testLimitConstructsCorrectStatement(int $limit, string $expected):void {
            $this->builder->limit($limit);

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