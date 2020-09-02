<?php

    //include_once("./config/autoload.php");
    
    use PHPUnit\Framework\TestCase;

    class TokenGeneratorTest extends TestCase {

        /**
         * Contains tested class
         *
         * @var TokenGenerator
         */
        protected $tokenGenerator;
        
        protected function setUp():void {
            $this->tokenGenerator = new TokenGenerator();
        }

        protected function tearDown():void {
            $this->tokenGenerator = null;
        }
        
        /**
         * @dataProvider provideTokenLength
         *
         * @param int $length - length of the Token
         * @param int $expected - expected Token length
         * @return void
         */
        public function testTokenLength(int $length, int $expected):void {
            self::assertEquals($expected, strlen($this->tokenGenerator->generateToken($length)));
        }

        public function provideTokenLength():array {
            return [
                "negative" => [-3, 0],
                "zero"     => [0, 0],
                "positive" => [20, 20]
            ];
        }
    }