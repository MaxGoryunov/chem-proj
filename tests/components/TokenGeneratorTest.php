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
         * @covers ::getKey
         * @covers ::getSymbols
         * 
         * @dataProvider provideInitSymbolsKeys
         * 
         * @small
         *
         * @param string[] $keys
         * @param (string|int)[] $expected
         * @return void
         */
        public function testGetSymbolsReturnsInitiatedSymbols(array $keys, array $expected):void {
            $this->assertEquals($expected, $this->tokenGenerator->getSymbols($keys));
        }
        
        /**
         * @covers ::getKey
         * @covers ::getSymbols
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
         * @covers ::getKey
         * @covers ::getSymbols
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
         * @covers ::generateUniqueToken
         *
         * @return void
         */
        public function testGenerateUniqueTokenGeneratesUniqueToken():void {
            $tokens = [];

            for ($i = 0; $i < 3; $i++) {
                usleep(1);
                $tokens[] = $this->tokenGenerator->generateUniqueToken();
            }

            for ($i = 0; $i < 2; $i++) {
                for ($j = $i + 1; $j < 3; $j++) {
                    $this->assertNotEquals($tokens[$i], $tokens[$j]);
                }
            }
        }

        /**
         * @covers ::getLetterSets
         *
         * @return void
         */
        public function testGetLetterSetsReturnsCorrectLetterSets():void {
            $sets = [
                array_flip(["a", "e", "i", "o", "u"]),
                array_flip(array_diff(range("a", "z"), ["a", "e", "i", "o", "u"]))
            ];

            $this->assertEquals($sets, $this->tokenGenerator->getLetterSets());
        }

        /**
         * @covers ::getLetterSets
         * @covers ::generatePseudoWord
         *
         * @return void
         */
        public function testGeneratePseudoWordsReturnsPseudoWord():void {
            $vowels     = "aeiou";
            $consonants = "b-df-hj-np-tv-z";

            $this->assertMatchesRegularExpression("/([{$vowels}][{$consonants}])+/", $this->tokenGenerator->generatePseudoWord());
        }

        /**
         * @covers ::getLetterSets
         * @covers ::generatePseudoWord
         * 
         * @dataProvider provideTokenLengths
         *
         * @param int $length   - token length
         * @param int $expected - expected length
         * @return void
         */
        public function testGeneratePseudoWordReturnsStringOfCorrectLength(int $length, int $expected):void {
            $this->assertEquals($expected, strlen($this->tokenGenerator->generatePseudoWord($length)));
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
                "digits"            => [[TokenGenerator::DIGITS], array_flip(range(0, 9))],
                "letters"           => [[TokenGenerator::LETTERS], array_flip(array_merge(range("a", "z"), range("A", "Z")))],
                "letters_lowercase" => [[TokenGenerator::LETTERS_LOWERCASE], array_flip(range("a", "z"))],
                "letters_uppercase" => [[TokenGenerator::LETTERS_UPPERCASE], array_flip(range("A", "Z"))],
                "all"               => [[TokenGenerator::ALL], array_flip(array_merge(range(0, 9), range("a", "z"), range("A", "Z")))]
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