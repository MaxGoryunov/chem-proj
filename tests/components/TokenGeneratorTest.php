<?php

    //include_once("./config/autoload.php");
    namespace Tests\Components;

    use Components\TokenGenerator;
    use PHPUnit\Framework\TestCase;
    use ReflectionClass;

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
         * @covers ::__construct
         * @covers ::getKey
         * 
         * @dataProvider provideKeys
         * 
         * @small
         *
         * @param string[] $range  - range of string keys
         * @param string $expected - expected result
         * @return void
         */
        public function testGetKeyReturnsCorrectKeys(array $range, string $expected):void {
            $reflection = new ReflectionClass($this->tokenGenerator);
            $getKey     = $reflection->getMethod("getKey");

            $getKey->setAccessible(true);

            $this->assertEquals($expected, $getKey->invokeArgs($this->tokenGenerator, [$range]));
        }

        /**
         * @covers ::__construct
         * @covers ::initSymbols
         * @covers ::getKey
         * 
         * @dataProvider provideInitSymbolsKeys
         * 
         * @small
         *
         * @param string[] $keys
         * @param (string|int)[] $expected
         * @return void
         */
        public function testInitSymbolsReturnsInitiatedSymbols(array $keys, array $expected):void {
            $this->assertEquals($expected, $this->tokenGenerator->initSymbols($keys));
        }
        
        /**
         * @covers ::__construct
         * @covers ::initSymbols
         * @covers ::getKey
         * @covers ::generateToken
         * 
         * @dataProvider provideTokenLengths
         * 
         * @small
         *
         * @param int $length   - length of the Token
         * @param int $expected - expected Token length
         * @return void
         */
        public function testGenerateTokenReturnsTokenOfSuppliedLength(int $length, int $expected):void {
            $this->assertEquals($expected, strlen($this->tokenGenerator->generateToken($length, [TokenGenerator::DIGITS])));
        }

        /**
         * @covers ::__construct
         * @covers ::initSymbols
         * @covers ::getKey
         * @covers ::generateToken
         * 
         * @dataProvider provideSymbolTypes
         * 
         * @small
         *
         * @param string[][] $keys - keys for generating tokens
         * @param string $expected - expected values of token symbols
         * @return void
         */
        public function testGenerateTokenReturnsStringsWithCorrectSymbols(array $keys, string $expected):void {
            $this->assertMatchesRegularExpression("/$expected+/", $this->tokenGenerator->generateToken(32, $keys));
        }

        /**
         * @return (string|string[])[][]
         */
        public function provideKeys():array {
            return [
                [["aaa"], "aaa"],
                [["aaa", "bbb", "ccc"], "aaabbbccc"],
                [["aaa", "BBB". "cCc"], "aaaBBBcCc"]
            ];
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
                "digits"            => [[TokenGenerator::DIGITS], range(0, 9)],
                "letters"           => [[TokenGenerator::LETTERS], array_merge(range("a", "z"), range("A", "Z"))],
                "letters_lowercase" => [[TokenGenerator::LETTERS_LOWERCASE], range("a", "z")],
                "letters_uppercase" => [[TokenGenerator::LETTERS_UPPERCASE], range("A", "Z")],
                "all"               => [[TokenGenerator::ALL], array_merge(range(0, 9), range("a", "z"), range("A", "Z"))]
            ];
        }

        /**
         * @return (string|string[][])[][]
         */
        public function provideSymbolTypes():array {
            return [
                "digits"            => [[TokenGenerator::DIGITS], "[0-9]"],
                "letters"           => [[TokenGenerator::LETTERS], "[a-zA-Z]"],
                "letters_lowercase" => [[TokenGenerator::LETTERS_LOWERCASE], "[a-z]"],
                "letters_uppercase" => [[TokenGenerator::LETTERS_UPPERCASE], "[A-Z]"],
                "all"               => [[TokenGenerator::ALL], "[0-9a-zA-Z]"]
            ];
        }
    }