<?php

    namespace Tests\Components;

    use Components\DataValidator;
    use InvalidArgumentException;
    use PHPUnit\Framework\TestCase;

    /**
     * @coversDefaultClass Components\DataValidator
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
         * @covers ::getFromSetOrThrowException
         * 
         * @dataProvider provideSets
         *
         * @param bool[] $set
         * @return void
         */
        public function testGetFromSetOrThrowExceptionReturnsFoundValue(array $set):void {
            foreach ($set as $key => $value) {
                $this->assertEquals($value, $this->dataValidator->GetFromSetOrThrowException($key, $set));
            }
        }

        /**
         * @covers ::getFromSetOrThrowException
         * 
         * @dataProvider provideSets
         *
         * @param bool[] $set
         * @return void
         */
        public function testGetFromSetOrThrowExceptionThrowsExceptionIfKeyIsNotAllowed(array $set):void {
            $this->expectException(InvalidArgumentException::class);

            $this->dataValidator->GetFromSetOrThrowException("aaa", $set);
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