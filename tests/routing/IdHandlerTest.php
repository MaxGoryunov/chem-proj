<?php

    namespace Tests\Routing;

use ControllerActions\ControllerAction;
use PHPUnit\Framework\TestCase;
    use Routing\IdHandler;
    use Routing\IRoutingHandler;

    /**
     * Testing IdHandler class
     * 
     * @coversDefaultClass Routing\IdHandler
     */
    class IdHandlerTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var IdHandler
         */
        protected $handler;

        /**
         * Contains object helping for testing
         *
         * @var ControllerAction
         */
        protected $action;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->handler = new IdHandler();
            $this->action  = new ControllerAction();
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
         * @covers ::fillData
         * 
         * @uses ControllerActions\ControllerAction
         * 
         * @dataProvider providePartedUriWithValidId
         * 
         * @small
         *
         * @param string[] $partedUri -  array of uri parts
         * @param int      $expected  - expected result
         * @return void
         */
        public function testHandleReturnsIdWithValidId(array $partedUri, int $expected):void {
            $this->assertContains($expected, $this->handler->handle($partedUri, $this->action)->getData());
        }

        /**
         * @covers ::handle
         * @covers ::fillData
         * 
         * @uses ControllerActions\ControllerAction
         * 
         * @dataProvider providePartedUriWithInvalidId
         * 
         * @small
         *
         * @param string[] $partedUri - array of uri parts
         * @param int      $expected  - expected result
         * @return void
         */
        public function testHandleDoesNotReturnInvalidId(array $partedUri, int $expected):void {
            $this->assertNotContains($expected, $this->handler->handle($partedUri, $this->action)->getData());
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