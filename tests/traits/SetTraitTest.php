<?php

    use DBQueries\IQuery;
    use DBQueries\IQueryBuilder;
    use PHPUnit\Framework\TestCase;
    use Traits\SetTrait;

    /**
     * Testing SetTrait trait
     * 
     * @coversDefaultClass Traits\SetTrait
     */
    class SetTraitTest extends TestCase {

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
                use SetTrait;

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
         * @covers ::set
         * @covers ::getValues
         * 
         * @dataProvider provideValues
         * 
         * @small
         *
         * @param array $values - values passed to 'set' method
         * @param string $expected - expected result
         * @return void
         */
        public function testSetConstructsCorrectStatement(array $values, string $expected):void {
            $this->assertInstanceOf(IQueryBuilder::class, $this->builder->set($values));

            $this->assertEquals($expected, $this->builder->getValues());
        }

        /**
         * Provides values for testing
         *
         * @return ((string|int)[]|string|array)[][]
         */
        public function provideValues():array {
            return [
                "empty"            => [[], ""],
                "actualValues"     => [
                    [
                        "medicine_name"  => "BeHealthy",
                        "medicine_price" => 500,
                        "medicine_doze"  => 30
                    ],
                    "`medicine_name` = 'BeHealthy', `medicine_price` = '500', `medicine_doze` = '30'"
                ],
                "nonStringIndexes" => [
                    [
                        "medicine_name"  => "Sensu Bean",
                        "medicine_price" => 300,
                        1                => 34
                    ],
                    ""
                ]
            ];
        }
    }