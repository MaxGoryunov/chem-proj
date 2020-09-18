<?php

    namespace Tests\Components;

    use Components\Router;
    use InvalidArgumentException;
use LogicException;
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
         * Set up required ROOT constant for 'run' method
         *
         * @return void
         */
        public static function setUpBeforeClass():void {
            define("ROOT", "/chem-proj/");
        }

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->router = new Router();
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
        public function testRunThrowsInvalidArgumentExceptionOnEmptyInput():void {
            $this->expectException(InvalidArgumentException::class);

            $this->router->run();
        }

        public function testRunThrowsLogicExceptionOnEmptyInput():void {
            $this->expectException(LogicException::class);

            $this->router->run("http://localhost/chem-proj/addresses/list");
        }

        /**
         * @covers ::run
         *
         * @return void
         */
        public function testRunSpeed():void {
            $this->markTestIncomplete();
            include_once("./config/routes.php");

            $this->router->setRoutes($routes);
            /**
             * Contains domains for testing 'run' method
             * 
             * @var string[]
             */
            $domains  = ["addresses", "companies", "chemicals", "countries", "genders", "medicines", "purposes"];
            $currTime = microtime(true);

            for ($i = 0; $i < 1000000; $i++) { 
                $this->router->run("http://localhost/chem-proj/" . $domains[mt_rand(0, count($domains) - 1)] . "/list");
            }

            $currTime = microtime(true) - $currTime;

            $this->assertLessThan(0.5, $currTime);
        }

    }