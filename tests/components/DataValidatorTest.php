<?php

    namespace Tests\Components;

    use Components\DataValidator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

    /**
     * @coversDefaultClass DataValidator
     */
    class DataValidatorTest extends TestCase {

        /**
         * @var DataValidator
         */
        protected $dataValidator;

        /**
         * @return void
         */
        protected function setUp():void {
            $this->dataValidator = new DataValidator();
        }

        /**
         * @return void
         */
        protected function tearDown():void {
            $this->dataValidator = null;
        }

        /**
         * @covers ::getFromSetOrException
         * 
         * @dataProvider provideSets
         *
         * @param bool[] $set
         * @return void
         */
        public function testGetFromSetOrExceptionReturnsFoundValue(array $set):void {
            foreach ($set as $key => $value) {
                $this->assertEquals($value, $this->dataValidator->GetFromSetOrException($key, $set));
            }
        }

        /**
         * @covers ::getFromSetOrException
         * 
         * @dataProvider provideSets
         *
         * @param bool[] $set
         * @return void
         */
        public function testGetFromSetOrExceptionThrowsExceptionIfKeyIsNotAllowed(array $set):void {
            $this->expectException(InvalidArgumentException::class);

            $this->dataValidator->GetFromSetOrException("aaa", $set);
        }

        /**
         * @return bool[][][]
         */
        public function provideSets():array {
            return [
                [
                    [
                        "index"  => false,
                        "add"    => false,
                        "edit"   => true,
                        "delete" => true
                    ]
                ]
            ];
        }
    }