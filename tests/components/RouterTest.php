<?php

    namespace Tests\Components;

    use Components\Router;
    use InvalidArgumentException;
    use LogicException;
    use PHPUnit\Framework\TestCase;


    /**
     * Testing Router class
     * 
     * @coversDefaultClass Components\Router
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
         * @small
         *
         * @return void
         */
        public function testRunThrowsInvalidArgumentExceptionOnEmptyInput():void {
            $this->expectException(InvalidArgumentException::class);

            $this->router->run();
        }

        /**
         * @covers ::run
         * 
         * @uses Controllers\IController
         * @uses Factories\AbstractFactory
         * @uses Factories\AddressesFactory
         * @uses Factories\GendersFactory
         * @uses Factories\IControllerFactory
         * @uses Factories\UserStatusesFactory
         * @uses Routing\AbstractHandler
         * @uses Routing\ActionHandler
         * @uses Routing\FactoryHandler
         * @uses Routing\IRoutingHandler
         * @uses Routing\IdHandler
         * @uses ControllerActions\ControllerAction
         * 
         * @small
         * 
         * @return void
         */
        public function testRunSpeed():void {
            $this->markTestIncomplete();
            $domains      = ["addresses", "genders", "user_statuses"];
            $actions      = ["list", "add", "edit/1", "delete/1"];
            $currTime     = microtime(true);
            $domainLength = count($domains) - 1;
            $actionLength = count($actions) - 1;
            $router       = new Router();

            for ($i = 0; $i < 100000; $i++) { 
                $router->run("/chem-proj/" . $domains[mt_rand(0, $domainLength)] . "/" . $actions[mt_rand(0, $actionLength)]);
            }

            $currTime = microtime(true) - $currTime;

            $this->assertLessThan(12, $currTime);

        }

        /**
         * @covers ::headerTo
         * 
         * @small
         * 
         * @runInSeparateProcess
         *
         * @return void
         */
        public function testHeaderToRedirectsToRightPath():void {
            $domains = ["addresses", "companies", "chemicals", "countries", "genders", "medicines", "purposes", "restricts"];
            $actions = ["list", "add", "edit/1", "delete/1"];

            foreach ($domains as $domain) {
                foreach ($actions as $action) {
                    Router::headerTo($domain . "/" . $action);

                    $this->assertContains("Location: " . $domain . "/" . $action, xdebug_get_headers());
                }
            }
        }
    }