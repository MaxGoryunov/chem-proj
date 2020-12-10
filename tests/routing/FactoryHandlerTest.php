<?php

    namespace Tests\Routing;

    use Factories\AddressesFactory;
    use Factories\GendersFactory;
    use Factories\UserStatusesFactory;
    use PHPUnit\Framework\TestCase;
    use Routing\FactoryHandler;
    use Routing\IRoutingHandler;

    /**
     * Testing FactoryHandler class
     * 
     * @coversDefaultClass FactoryHandler
     */
    class FactoryHandlerTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var FactoryHandler
         */
        protected $handler;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->handler = new FactoryHandler();
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->handler = null;
        }

        /**
         * @covers ::handle
         * 
         * @dataProvider providePartedUriWithValidFactoryName
         *
         * @param string[] $partedUri - array of URI parts
         * @param string $expected    - expected result
         * @return void
         */
        public function testHandleReturnsFactoryName(array $partedUri, string $expected):void {
            $this->assertContains($expected, $this->handler->handle($partedUri));
        }

        /**
         * @covers ::handle
         *
         * @return void
         */
        public function testHandleContainsResultsOfNextHandler():void {
            $nextHandler = $this->getMockBuilder(IRoutingHandler::class)
                            ->onlyMethods(["handle", "setNextHandler"])
                            ->getMock();

            $nextHandler->expects($this->once())
                        ->method("handle")
                        ->will($this->returnValue(["action" => "edit"]));

            $this->handler->setNextHandler($nextHandler);
            $this->assertContains("edit", $this->handler->handle(["", "chem-proj", "addresses", "edit", "22"]));
        }

        /**
         * @covers ::handle
         * 
         * @runInSeparateProcess
         *
         * @return void
         */
        public function testHandleRedirectsToErrorPageOnFailedInput():void {
            $partedUri = ["", "chem-proj", "aaa"];

            $this->handler->handle($partedUri);
            $this->assertContains("Location: ./errors/not_found", xdebug_get_headers());
        }

        /**
         * @return (string|string[])[][]
         */
        public function providePartedUriWithValidFactoryName():array {
            $offset = ["", "chem-proj"];

            return [
                [array_merge($offset, ["addresses", "edit", "12"]), AddressesFactory::class],
                [array_merge($offset, ["genders", "add"]), GendersFactory::class],
                [array_merge($offset, ["user_statuses", "index"]), UserStatusesFactory::class]
            ];
        }
    }