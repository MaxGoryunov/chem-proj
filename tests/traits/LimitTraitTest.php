<?php

    use PHPUnit\Framework\TestCase;

    /**
     * Testing LimitTrait trait
     * 
     * @coversDefaultClass LimitTrait
     */
    class LimitTraitTest extends TestCase {

        protected $builder;

        protected function setUp():void {
            $this->builder = $this->createMock(IQueryBuilder::class);
        }

        /**
         * @covers ::limit
         *
         * @return void
         */
        public function testLimitConstructsCorrectStatement():void {
            
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