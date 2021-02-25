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
         * @small
         *
         * @param bool[] $set
         * @return void
         */
        public function testGetFromSetOrThrowExceptionReturnsFoundValue(array $set):void {
            foreach ($set as $key => $value) {
                $this->assertEquals($value, $this->dataValidator->getFromSetOrThrowException($key, $set));
            }
        }

        /**
         * @covers ::getFromSetOrThrowException
         * 
         * @dataProvider provideSets
         * 
         * @small
         *
         * @param bool[] $set
         * @return void
         */
        public function testGetFromSetOrThrowExceptionThrowsExceptionIfKeyIsNotAllowed(array $set):void {
            $this->expectException(InvalidArgumentException::class);

            $this->dataValidator->getFromSetOrThrowException("aaa", $set);
        }

        /**
         * @covers ::getFromSetOrCallClosure
         * 
         * @dataProvider provideSets
         * 
         * @small
         *
         * @param bool[] $set
         * @return void
         */
        public function testGetFromSetOrCallClosureReturnsFoundValue(array $set):void {
            foreach ($set as $key => $value) {
                $this->assertEquals($value, $this->dataValidator->GetFromSetOrCallClosure($key, $set, function() {
                    echo "Value not found";
                }));
            }
        }

        /**
         * @covers ::getFromSetOrCallClosure
         * 
         * @dataProvider provideSets
         * 
         * @small
         *
         * @param bool[] $set
         * @return void
         */
        public function testGetFromSetOrCallClosureCallsClosureIfKeyIsNotFound(array $set):void {
            $this->expectOutputString("1234");

            $closure = function() {
                static $count = 0;
                $count++;
                echo $count;
            };
            
            for ($i = 0; $i < 4; $i++) { 
                $this->dataValidator->GetFromSetOrCallClosure("aaa", $set, $closure);
            }
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