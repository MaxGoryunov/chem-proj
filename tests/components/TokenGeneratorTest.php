<?php
    
    use PHPUnit\Framework\TestCase;

    /**
     * Testing TokenGenerator class
     */
    class TokenGeneratorTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var TokenGenerator
         */
        protected $tokenGenerator;
        
        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->tokenGenerator = new TokenGenerator();
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->tokenGenerator = null;
        }

        /**
         * @return void
         */
        public function testInitSymbolsReturnsActualNumberOfSymbols():void {
            $this->assertEquals(62, $this->tokenGenerator->initSymbols());
        }
        
        /**
         * @dataProvider provideTokenLengths
         *
         * @param int $length - length of the Token
         * @param int $expected - expected Token length
         * @return void
         */
        public function testGeneratorReturnsTokenOfSuppliedLength(int $length, int $expected):void {
            $this->assertEquals($expected, strlen($this->tokenGenerator->generateToken($length)));
        }

        public function provideTokenLengths():array {
            return [
                "negative" => [-3, 0],
                "zero"     => [0, 0],
                "positive" => [20, 20]
            ];
        }
    }