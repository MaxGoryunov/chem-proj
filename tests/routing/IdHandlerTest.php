<?php

    namespace Tests\Routing;

    use PHPUnit\Framework\TestCase;
    use Routing\IdHandler;
    use Routing\IRoutingHandler;

    /**
     * Testing IdHandler class
     * 
     * @coversDefaultClass IdHandler
     */
    class IdHandlerTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var IdHandler
         */
        protected $handler;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->handler = new IdHandler();
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
         * @dataProvider providePartedUriWithValidId
         *
         * @param string[] $partedUri -  array of uri parts
         * @param int $expected       - expected result
         * @return void
         */
        public function testHandleReturnsIdWithValidId(array $partedUri, int $expected):void {
            $this->assertContains($expected, $this->handler->handle($partedUri));
        }

        /**
         * @covers ::handle
         * 
         * @dataProvider providePartedUriWithInvalidId
         *
         * @param string[] $partedUri - array of uri parts
         * @param int $expected       - expected result
         * @return void
         */
        public function testHandleDoesNotReturnInvalidId(array $partedUri, int $expected):void {
            $this->assertNotContains($expected, $this->handler->handle($partedUri));
        }

        /**
         * @covers ::setNextHandler
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
            $this->assertContains("edit", $this->handler->handle(["", "chem-proj", "addresses", "edit", "34"]));
        }

        /**
         * Returns parted uri with valid ids
         *
         * @return (string[]|int)[][]
         */
        public function providePartedUriWithValidId():array {
            $offset = ["", "chem-proj"];

            return [
                [array_merge($offset, ["addresses", "edit", "12"]), 12],
                [array_merge($offset, ["chemicals", "delete", "27"]), 27],
                [array_merge($offset, ["companies", "edit", "3"]), 3]
            ];
        }

        /**
         * Returns parted uri with invalid ids
         *
         * @return string[][][]
         */
        public function providePartedUriWithInvalidId():array {
            $offset = ["", "chem-proj"];

            return [
                "uriWWithoutId"          => [array_merge($offset, ["addresses", "add"]), 12],
                "uriWithLettersAfterId"  => [array_merge($offset, ["chemicals", "edit", "27asd"]), 27],
                "uriWithLettersBeforeId" => [array_merge($offset, ["companies", "edit", "asd3"]), 3]
            ];
        }
    }