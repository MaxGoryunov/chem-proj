<?php

    namespace Tests\Components;

    use Components\Router;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

    /**
     * Testing Router class
     * 
     * @coversDefaultClass Router
     */
    class RouterTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var Router
         */
        protected $router;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->router = new Router();
            define("ROOT", "/chem-proj/");
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->router = null;
        }

        /**
         * @covers ::run
         *
         * @return void
         */
        public function testRunThrowsExceptionOnEmptyInput():void {
            $this->expectException(InvalidArgumentException::class);

            $this->router->run();
        }

    }