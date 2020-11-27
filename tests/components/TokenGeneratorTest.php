<?php

    //include_once("./config/autoload.php");
    namespace Tests\Components;

    use Components\TokenGenerator;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing TokenGenerator class
     * 
     * @coversDefaultClass Components\TokenGenerator
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
         * @covers ::initSymbols
         * 
         * @dataProvider provideInitSymbolsKeys
         *
         * @param string[] $keys
         * @param (string|int)[] $expected
         * @return void
         */
        public function testInitSymbolsReturnsInitiatedSymbols(array $keys, array $expected):void {
            $this->assertEquals($expected, $this->tokenGenerator->initSymbols($keys));
        }
        
        /**
         * @covers ::initSymbols
         * @covers ::generateToken
         * 
         * @dataProvider provideTokenLengths
         *
         * @param int $length   - length of the Token
         * @param int $expected - expected Token length
         * @return void
         */
        public function testGenerateTokenReturnsTokenOfSuppliedLength(int $length, int $expected):void {
            $this->assertEquals($expected, strlen($this->tokenGenerator->generateToken($length, ["digits"])));
        }

        /**
         * @covers ::initSymbols
         * @covers ::generateToken
         *
         * @return void
         */
        public function testGenerateTokenReturnsOnlyDigitsOnDigitsKey():void {
            $this->assertEquals(1, preg_match("/^([0-9])+$/", $this->tokenGenerator->generateToken(32, [TokenGenerator::DIGITS])));
        }

        /**
         * Provides Lengths and expected results for test
         *
         * @return int[][]
         */
        public function provideTokenLengths():array {
            return [
                "negative" => [-3, 0],
                "zero"     => [0, 0],
                "positive" => [20, 20]
            ];
        }

        /**
         * @return (string[]|int[])[][]
         */
        public function provideInitSymbolsKeys():array {
            return [
                "digits"  => [["digits"], range(0, 9)],
                "letters" => [["letters"], array_merge(range("a", "z"), range("A", "Z"))]
            ];
        }
    }